<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'user_id'
    ];

    public function categories () {
        return $this->hasMany(ItemCategories::class);
    }
}
