<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'barista_id',
        'capital_price',
        'selling_price',
        'qty',
        'status',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function barista() {
        return $this->belongsTo(Barista::class);
    }
}
