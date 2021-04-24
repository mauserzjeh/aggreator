<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_QUEUED = 'queued';
    const STATUS_INPROGRESS = 'in_progress';
    const STATUS_DELIVERED = 'delivered';

    const STATUSES = [
        self::STATUS_QUEUED => 'Queued',
        self::STATUS_INPROGRESS => 'In progress',
        self::STATUS_DELIVERED => 'Delivered'
    ];

    protected $fillable = [
        'restaurant_id',
        'customer_id',
        'status',
        'city',
        'zip_code',
        'address',
        'phone'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function total_price() {
        $total = 0;

        $orderItems = $this->items;
        foreach($orderItems as $item) {
            $total += ($item->unit_price * $item->quantity);
        }

        return $total;
    }
}
