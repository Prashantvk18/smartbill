<?php

namespace App\Helpers;

use App\Models\BillData;
use Carbon\Carbon;

class BillHelper
{
    public static function generateBillNo($shop)
    {
        $year = Carbon::now()->year;

        $lastBill = BillData::where('shop_id', $shop->id)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastBill) {
            $lastNumber = intval(substr($lastBill->bill_no, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$shop->shop_code}-{$year}-{$newNumber}";
    }
}
