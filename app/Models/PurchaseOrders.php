<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
    use HasFactory;


    public function purchaseOrderDetails () {
        return $this->hasMany(PurchaseOrderDetails::class);
    }
}
