<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    
    protected $fillable = [
        'order_id',
        'quantity',
        'unit_price',
        'name'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}