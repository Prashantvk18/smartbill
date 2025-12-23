<?php

namespace App\Http\Controllers;

use App\Models\BillData;
use App\Models\ItemData;
use App\Models\Shop;
use App\Helpers\BillHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class BillController extends Controller
{
   public function store(Request $request)
{
    // 🔐 BASIC VALIDATION
    $request->validate([
        'shop_id'   => 'required|exists:shops,id',
        'bill_date' => 'required|date',
        'item_name' => 'required|array|min:1',
        'quantity'  => 'required|array|min:1',
        'price'     => 'required|array|min:1',
    ]);

    $userId = Auth::id();

    $shop = Shop::findOrFail($request->shop_id);
    if ($shop->created_by != $userId) {
        abort(403);
    }

    DB::transaction(function () use ($request, $shop, $userId) {

        // 🔢 RE-CALCULATE TOTAL (SECURITY)
        $total = 0;
        foreach ($request->quantity as $i => $qty) {
            $total += ($qty * ($request->price[$i] ?? 0));
        }

        // 💰 BALANCE LOGIC
        $balance = $request->balance1 ?? 0;
        $paid = $total - $balance;

        /* =====================================================
           ✏️ UPDATE BILL (EDIT MODE)
        ===================================================== */
        
        if ($request->bill_id) {

            $bill = BillData::where('id', $request->bill_id)
                ->where('shop_id', $shop->id)
                ->firstOrFail();

            // 🔄 UPDATE BILL
            $bill->update([
                'customer_name'   => $request->customer_name,
                'bill_date'       => $request->bill_date,
                'whatsapp_number' => $request->whatsapp_number,

                'is_warranty'     => $request->has('is_warranty'),
                'is_guarantee'    => $request->has('is_guarantee'),
                'details'         => $request->details,

                'total_amount'    => $total,
                'paid'            => $paid,
                'balance'         => $balance,

                'is_sign'         => $request->has('is_sign'),
                'is_stamp'        => $request->has('is_stamp'),

                'updated_by'      => $userId,
                'pdf_send'        => $request->action === 'send' ? 1 : 0,
            ]);

            // 🧹 DELETE OLD ITEMS
            ItemData::where('bill_id', $bill->id)->delete();
        }

        /* =====================================================
           ➕ CREATE BILL (NEW MODE)
        ===================================================== */
        else {

            // 🧾 GENERATE BILL NUMBER
            $billNo = BillHelper::generateBillNo($shop);

            $bill = BillData::create([
                'shop_id'         => $shop->id,
                'customer_name'   => $request->customer_name,
                'bill_no'         => $billNo,
                'bill_date'       => $request->bill_date,
                'whatsapp_number' => $request->whatsapp_number,

                'is_warranty'     => $request->has('is_warranty'),
                'is_guarantee'    => $request->has('is_guarantee'),
                'details'         => $request->details,

                'total_amount'    => $total,
                'paid'            => $paid,
                'balance'         => $balance,

                'is_sign'         => $request->has('is_sign'),
                'is_stamp'        => $request->has('is_stamp'),

                'created_by'      => $userId,
                'pdf_send'        => $request->action === 'send' ? 1 : 0,
            ]);
        }

        /* =====================================================
           📦 SAVE ITEMS (COMMON)
        ===================================================== */
        foreach ($request->item_name as $i => $itemName) {
            if (!$itemName) continue;

            ItemData::create([
                'bill_id'   => $bill->id,
                'bill_no'   => $bill->bill_no,
                'item_name' => $itemName,
                'quantity'  => $request->quantity[$i],
                'price'     => $request->price[$i],
                'added_by'  => $userId,
            ]);
        }

        /* =====================================================
           📲 SEND WHATSAPP (OPTIONAL)
        ===================================================== */
        if ($request->action === 'send') {
            $msg = "Your bill {$bill->bill_no} is ready.";
            $url = "https://wa.me/91{$request->whatsapp_number}?text=" . urlencode($msg);
            redirect($url)->send();
        }

    });

    return back()->with('success', 'Bill saved successfully');
}

    public function updateBalance(Request $request)
{
    $request->validate([
        'bill_id' => 'required|exists:bill_data,id',
        'balance' => 'required|numeric|min:0'
    ]);

    $bill = BillData::findOrFail($request->bill_id);

    $paid = $bill->total_amount - $request->balance;

    $bill->update([
        'balance' => $request->balance,
        'paid'    => $paid,
        'updated_by' => Auth::id()
    ]);

    return back()->with('success', 'Balance updated successfully');
}

public function generatePdfInternal(BillData $bill)
{
    // Owner check
    if ($bill->created_by !== auth()->id()) {
        abort(403);
    }

    return $this->generateOrServePdf($bill);
}

public function generatePdfPublic(Request $request, BillData $bill)
{
    // Signed middleware already validated signature + expiry
    return $this->generateOrServePdf($bill);
}

private function generateOrServePdf(BillData $bill)
{
    if (
        $bill->is_pdf &&
        $bill->pdf_generate_date &&
        Carbon::parse($bill->pdf_generate_date)->addDays(30)->isFuture() &&
        Storage::disk('public')->exists($bill->pdf_path)
    ) {
        return response()->file(
            storage_path('app/public/' . $bill->pdf_path)
        );
    }

    $shop  = $bill->shop;
    $owner = $bill->creator;
    $items = $bill->items;

    $pdf = Pdf::loadView('pdf.bill', compact('bill','shop','owner','items'))
        ->setPaper('A4');

    $path = 'bills/' . $bill->bill_no . '.pdf';
    Storage::disk('public')->put($path, $pdf->output());

    $bill->update([
        'is_pdf' => 1,
        'pdf_generate_date' => now(),
        'pdf_path' => $path,
    ]);

    return response()->file(
        storage_path('app/public/' . $path)
    );
}

   public function generatePdf(Request $request, BillData $bill)
{
    // 🔐 SIGNATURE VALIDATION (CRITICAL)
     if (auth()->check()) {
        if ($bill->created_by !== auth()->id()) {
            abort(403);
        }
    }
    // 🔐 If public access → require signed URL
    else {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired link');
        }
    }

    // ♻️ Reuse PDF if valid (30 days)
    if (
        $bill->is_pdf &&
        $bill->pdf_generate_date &&
        Carbon::parse($bill->pdf_generate_date)->addDays(30)->isFuture() &&
        Storage::disk('public')->exists($bill->pdf_path)
    ) {
        return response()->file(
            storage_path('app/public/' . $bill->pdf_path)
        );
    }

    $shop  = $bill->shop;
    $owner = $bill->creator;
    $items = $bill->items;

    $pdf = Pdf::loadView('pdf.bill', compact(
        'bill', 'shop', 'owner', 'items'
    ))
    ->setPaper('A4')
    ->setOptions([
        'defaultFont' => 'DejaVu Sans',
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'chroot' => realpath(base_path()), // ⭐ REQUIRED on Windows
    ]);

    $fileName = $bill->bill_no . '.pdf';
    $path = 'bills/' . $fileName;

    // Save PDF
    Storage::disk('public')->put($path, $pdf->output());

    // Update DB
    $bill->update([
        'is_pdf'            => 1,
        'pdf_generate_date' => Carbon::today(),
        'pdf_path'          => $path,
    ]);

    return response()->file(
        storage_path('app/public/' . $path)
    );
}
public function generateAndSendPdf(Request $request, BillData $bill)
{
    // 🔐 Ensure signed access
     if (auth()->check()) {
        if ($bill->created_by !== auth()->id()) {
            abort(403);
        }
    }
    // 🔐 If public access → require signed URL
    else {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired link');
        }
    }


    // Generate PDF if missing or expired
    if (
        !$bill->is_pdf ||
        Carbon::parse($bill->pdf_generate_date)->addDays(30)->isPast()
    ) {
      
        $this->generatePdf($request, $bill);
        $bill->refresh();
    }

    // 🔐 TEMPORARY SIGNED DOWNLOAD LINK
    $downloadUrl = URL::temporarySignedRoute(
        'bill.pdf.public',
        now()->addDays(7), // link valid for 7 days
        ['bill' => $bill->id]
    );
    dd($downloadUrl);
    $message = "Hello 👋\n"
        . "Your bill *{$bill->bill_no}* is ready.\n\n"
        . "📄 Download PDF:\n{$downloadUrl}\n\n"
        . "⏳ Link valid for 30 minutes.\n"
        . "Thank you for shopping 🙏";

    if ($bill->whatsapp_number) {
        return redirect(
            "https://wa.me/91{$bill->whatsapp_number}?text=" . urlencode($message)
        );
    }

    return back()->with('failed', 'Mobile number not available');
}

public function viewPdf(BillData $bill)
{
    // Security: owner only
    if ($bill->created_by !== auth()->id()) {
        abort(403);
    }

    // Check PDF exists
    if (!$bill->is_pdf || !$bill->pdf_path) {
        abort(404, 'PDF not available');
    }

    $fullPath = storage_path('app/public/' . $bill->pdf_path);

    if (!file_exists($fullPath)) {
        abort(404, 'File missing');
    }

    return response()->file($fullPath, [
        'Content-Type' => 'application/pdf'
    ]);
}

public function removePdf(BillData $bill)
{
    if ($bill->pdf_path && Storage::disk('public')->exists($bill->pdf_path)) {
        Storage::disk('public')->delete($bill->pdf_path);
    }

    $bill->update([
        'pdf_path' => null,
        'is_pdf' => 0,
        'pdf_generate_date' => null
    ]);

    return back()->with('success', 'PDF removed. You can generate a new one.');
}

}
