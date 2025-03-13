<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'desc',
        'capital_price',
        'selling_price',
        'qty',
        'image_path',
    ];

    public function itemCategory() {
        return $this->hasMany(ItemCategory::class);
    }
}
