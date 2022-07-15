<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $casts = [
        'item_attributes' => 'array',
    ];

    public function subcategories() {
        return $this->belongsTo(ItemSubcategories::class, 'item_subcategories_id', 'id');
    }
}
