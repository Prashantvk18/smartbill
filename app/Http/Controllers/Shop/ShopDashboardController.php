<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BillData;
use App\Models\ItemData;
use App\Helpers\BillHelper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopDashboardController extends Controller
{
    public function index(Request $request, $shop)
{
    // Default date range = current month
    $from = $request->from_date ?? Carbon::now()->startOfMonth()->toDateString();
    $to   = $request->to_date   ?? Carbon::now()->endOfMonth()->toDateString();

    $query = BillData::with('items')->where('shop_id', $shop)
        ->whereBetween('bill_date', [$from, $to]);
    $shop_name = Shop::find($shop)->shop_name;
    // Search filter
    if ($request->search_type && $request->search_value) {
        $query->where($request->search_type, 'like', '%' . $request->search_value . '%');
    }

    $bills = $query->orderBy('bill_date', 'desc')->get();

    return view('shop.dashboard', compact(
        'bills',
        'from',
        'to',
        'shop',
        'shop_name'
    ));
}
}
