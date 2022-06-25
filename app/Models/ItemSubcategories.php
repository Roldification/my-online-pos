<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubcategories extends Model
{
    use HasFactory;

    public function categories() {
        return $this->belongsTo(ItemCategories::class, 'item_categories_id');
    }
}
