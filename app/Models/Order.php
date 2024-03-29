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
    const STATUS_TO_BE_DELIVERED = 'to_be_delivered';

    const STATUSES = [
        self::STATUS_QUEUED => 'Queued',
        self::STATUS_INPROGRESS => 'In progress',
        self::STATUS_DELIVERED => 'Delivered',
        self::STATUS_TO_BE_DELIVERED => 'To be delivered'
    ];

    const TYPE_DELIVERY = 'delivery';
    const TYPE_TAKEAWAY = 'take_away';

    const DELIVERY_TYPES = [
        self::TYPE_DELIVERY => 'Delivery',
        self::TYPE_TAKEAWAY => 'Take away'
    ];

    const PRIORITY_LOW = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_HIGH = 3;

    const PRIORITIES = [
        self::PRIORITY_LOW => "Low",
        self::PRIORITY_NORMAL => "Normal",
        self::PRIORITY_HIGH => "High"
    ];

    const PRIORITY_HIGHER = '+';
    const PRIORITY_LOWER = '-';

    protected $fillable = [
        'restaurant_id',
        'customer_id',
        'courier_id',
        'status',
        'priority',
        'delivery_type',
        'expected_delivery_time',
        'city',
        'zip_code',
        'address',
        'phone'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function courier() {
        return $this->belongsTo(User::class, 'courier_id', 'id');
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
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
