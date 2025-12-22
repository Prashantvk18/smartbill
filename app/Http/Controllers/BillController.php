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

class BillController extends Controller
{
    public function store(Request $request)
    {
        // 🔐 BASIC VALIDATION
        $request->validate([
            'shop_id'        => 'required|exists:shops,id',
            'bill_date'      => 'required|date',
            'item_name'      => 'required|array|min:1',
            'quantity'       => 'required|array|min:1',
            'price'          => 'required|array|min:1',
        ]);

        $shop = Shop::findOrFail($request->shop_id);

        DB::transaction(function () use ($request, $shop) {

            // 🧾 GENERATE BILL NUMBER
            $billNo = BillHelper::generateBillNo($shop);

            // 🔢 RE-CALCULATE TOTAL (DO NOT TRUST FRONTEND)
            $total = 0;
            foreach ($request->quantity as $index => $qty) {
                $price = $request->price[$index];
                $total += ($qty * $price);
            }

            // 💰 BALANCE LOGIC
            $balance = $request->balance ?? 0;
            $paid = $total - $balance;

            // 🧾 SAVE BILL DATA
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

                'created_by'      => Auth::id(),
                'pdf_send'        => $request->action === 'send' ? 1 : 0,
            ]);

            // 📦 SAVE ITEMS
            foreach ($request->item_name as $index => $itemName) {
                ItemData::create([
                    'bill_id'  => $bill->id,
                    'bill_no'  => $billNo,
                    'item_name'=> $itemName,
                    'quantity' => $request->quantity[$index],
                    'price'    => $request->price[$index],
                    'added_by' => Auth::id(),
                ]);
            }

            // 📲 IF SEND → WHATSAPP REDIRECT
            if ($request->action === 'send') {
                $msg = "Your bill {$billNo} is ready.";
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
        'paid'    => $paid
    ]);

    return back()->with('success', 'Balance updated successfully');
}

   public function generatePdf(BillData $bill)
    {
        // Safety: allow only owner
        if ($bill->created_by !== auth()->id()) {
            abort(403);
        }

        // Reuse PDF if valid (within 30 days)
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
            'isRemoteEnabled' => false,
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

        // Stream PDF securely
        return response()->file(
            storage_path('app/public/' . $path)
        );
    }
public function generateAndSendPdf(BillData $bill)
{
    // Ensure PDF exists & is valid
    if (!$bill->is_pdf ||
        Carbon::parse($bill->pdf_generate_date)->addDays(30)->isPast()) {

        $this->generatePdf($bill);
        $bill->refresh();
    }

    // $downloadUrl = url(Storage::url($bill->pdf_path));
    $downloadUrl = route('bill.pdf.view', $bill->id);

    $message = "Hello 👋\n"
        . "Your bill *{$bill->bill_no}* is ready.\n\n"
        . "📄 Download PDF:\n{$downloadUrl}\n\n"
        . "Thank you for shopping 🙏";

    return redirect(
        "https://wa.me/91{$bill->whatsapp_number}?text=" . urlencode($message)
    );
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
}
