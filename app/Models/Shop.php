<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'shop_code',
        'owner_id',
        'created_by',
        'updated_by',
        'is_paid',
        'paid_amount',
        'dop',
        'doe',
        'signature_path',
        'stamp_path',
    ];

    public function bills()
{
    return $this->hasMany(BillData::class, 'shop_id');
}

}
