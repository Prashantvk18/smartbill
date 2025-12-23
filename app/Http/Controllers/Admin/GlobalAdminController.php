<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\shop;
use Carbon\Carbon;
use App\Models\shopPayment;


class GlobalAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        $shops = shop::orderBy('shop_name')->get();

           return view('admin.settings', compact('users', 'shops'));
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:6',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }

   

public function activateshop(Request $request)
{
    $request->validate([
        'shop_id' => 'required|exists:shops,id',
        'amount'  => 'required|numeric|min:0',
        'dop'     => 'required|date',
    ]);

    $doe = \Carbon\Carbon::parse($request->dop)->addMonths(12);

    $shop = shop::find($request->shop_id);

    // Update shop
    $shop->is_paid = 1;
    $shop->paid_amount  = $request->amount;
    $shop->dop     = $request->dop;
    $shop->doe     = $doe;
    $shop->save();

    // ✅ INSERT PAYMENT HISTORY
    shopPayment::create([
        'shop_id'      => $shop->id,
        'activated_by' => auth()->id(),
        'amount'       => $request->amount,
        'dop'          => $request->dop,
        'doe'          => $doe,
    ]);

    return back()->with('success', 'shop activated & payment recorded');
}


public function deactivateshop(Request $request)
{
    $request->validate([
        'shop_id' => 'required|exists:shops,id',
    ]);

    $shop = shop::find($request->shop_id);

    $shop->is_paid = 0;
    $shop->paid_amount  = 0;
    $shop->dop     = null;
    $shop->doe     = null;
    $shop->updated_by = auth()->id();
    $shop->save();

    return back()->with('success', 'shop deactivated successfully');
}

public function paymentHistory()
{
    $payments = shopPayment::with(['shop', 'admin'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.payment-history', compact('payments'));
}

}
