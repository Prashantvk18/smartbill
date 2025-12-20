<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings', [
            'users' => User::all(),
            'shops' => Shop::all()
        ]);
    }

    public function updateUserPassword(Request $request)
    {
        User::where('id', $request->user_id)
            ->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated');
    }

    public function updateShopPayment(Request $request)
    {
        Shop::where('id', $request->shop_id)->update([
            'is_paid'     => 1,
            'paid_amount' => $request->paid_amount,
            'dop'         => $request->dop,
            'doe'         => $request->doe,
        ]);

        return back()->with('success', 'Shop activated');
    }

    public function deactivateShop(Request $request)
    {
        Shop::where('id', $request->shop_id)->update([
            'is_paid' => 0,
            'dop'     => null,
            'doe'     => null,
        ]);

        return back()->with('success', 'Shop deactivated');
    }
}
