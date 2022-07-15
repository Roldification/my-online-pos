<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_orders_id',
        'items_id',
        'quantity',
        'tentative_total_price',
        'item_properties',
        'users_id',
        'uom',
    ];

    public function item() {
        return $this->belongsTo(Items::class);
    }
}
