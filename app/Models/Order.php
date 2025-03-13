<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cashier_id',
        'order_number',
        'discount',
        'date',
        'status',
        'payment_method_id',
    ];

    public function cashier() {
        return $this->belongsTo(Cashier::class);
    }

    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderDetail() {
        return $this->hasMany(OrderDetail::class);
    }
}
