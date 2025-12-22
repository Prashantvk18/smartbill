<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $shops = Shop::where('owner_id', Auth::id())->get();
        return view('dashboard.home', compact('shops'));
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
        ]);
    do {
        $code = rand(10000, 99999);
    } while (Team::where('team_code', $code)->exists());

        Shop::create([
            'shop_name'   => $request->shop_name,
            'shop_code'   => $code,
            'owner_id'    => Auth::id(),
            'created_by'  => Auth::id(),
            'updated_by'  => Auth::id(),
            'is_paid'     => 0,
            'paid_amount' => 0,
            'dop'         => null,
            'doe'         => null,
        ]);

        return redirect()->back()->with('success', 'Shop added successfully');
    }
}
