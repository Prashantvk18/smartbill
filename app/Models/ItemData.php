<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemData extends Model
{
    use HasFactory;

    protected $table = 'item_data';

    protected $fillable = [
        'bill_id',
        'bill_no',
        'item_name',
        'quantity',
        'price',
        'added_by',
    ];

    /* ======================
       RELATIONSHIPS
    ======================= */

    // Item belongs to bill
    public function bill()
    {
        return $this->belongsTo(BillData::class, 'bill_id');
    }

    // Item added by user
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
