<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Shop;
use Carbon\Carbon;


class CheckShopPaid
{
    public function handle(Request $request, Closure $next)
    {
        $shopId = $request->route('shop');

        if ($shopId) {
            $shop = Shop::find($shopId);

            if (!$shop) {
                abort(404);
            }

            // 🔒 AUTO-EXPIRE CHECK
            if ($shop->is_paid && $shop->doe && Carbon::parse($shop->doe)->lt(Carbon::today())) {

                // Auto lock shop
                $shop->is_paid = 0;
                $shop->amount  = null;
                $shop->dop     = null;
                $shop->doe     = null;
                $shop->save();
            }

            // Block access if unpaid
            if ($shop->is_paid == 0) {
                return redirect()
                    ->route('dashboard')
                    ->with('error', 'Your shop plan has expired. Please renew to continue.');
            }
        }

        return $next($request);
    }
}
