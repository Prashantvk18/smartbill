<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPayment extends Model
{
    protected $fillable = [
        'shop_id',
        'activated_by',
        'amount',
        'dop',
        'doe',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'activated_by');
    }
}
