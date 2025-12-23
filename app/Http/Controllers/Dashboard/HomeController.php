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
        if (!$request->shop_id) {
            do {
                $code = rand(10000, 99999);
                } while (Shop::where('shop_code', $code)->exists());
            
            $data = [
                'shop_name'   => $request->shop_name,
                'address' => $request->address,
                'shop_code'   => $code,
                'owner_id'    => Auth::id(),
                'created_by'  => Auth::id(),
            ];
        }else{
             $data = [
                'shop_name'   => $request->shop_name,
                'address' => $request->address,                           
                'updated_by'  => Auth::id(),
            ];
        }  
        if ($request->hasFile('signature')) {
            $data['signature_path'] =
                $request->file('signature')->store('shops/signatures', 'public');
        }

        // Upload stamp
        if ($request->hasFile('stamp')) {
            $data['stamp_path'] =
                $request->file('stamp')->store('shops/stamps', 'public');
        }
        if ($request->shop_id) {
            Shop::where('id', $request->shop_id)->update($data);
            return back()->with('success', 'Shop updated successfully');
        }   
        
        Shop::create($data);
        return redirect()->back()->with('success', 'Shop added successfully');
      
        
           
        
    }
}
