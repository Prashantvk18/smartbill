<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillData extends Model
{
    use HasFactory;

    protected $table = 'bill_data';

    protected $fillable = [
        'shop_id',
        'customer_name',
        'bill_no',
        'bill_date',
        'whatsapp_number',
        'is_warranty',
        'is_guarantee',
        'details',
        'total_amount',
        'paid',
        'balance',
        'is_sign',
        'is_stamp',
        'created_by',
        'is_pdf',
        'pdf_generate_date',
        'pdf_path',
        'pdf_send',
    ];

    /* ======================
       RELATIONSHIPS
    ======================= */

    // One bill has many items
    public function items()
    {
        return $this->hasMany(ItemData::class, 'bill_id');
    }

    // Bill belongs to shop
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    // Bill created by user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
