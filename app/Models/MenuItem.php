<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_category_id',
        'name',
        'price',
        'description'
    ];

    public function allergenes() {
        return $this->belongsToMany(Allergene::class, 'allergenes_menu_items', 'menu_item_id', 'allergene_id');
    }

    public function category() {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function discounts() {
        return $this->belongsToMany(Discount::class, 'discounts_menu_items', 'menu_item_id', 'discount_id');
    }

    public function discounted_price() {
        $item_discounts = $this->discounts()
                        ->where('start_timestamp', '<=', date('Y-m-d'))
                        ->where('end_timestamp', '>=', date('Y-m-d'))
                        ->where('active', 1)
                        ->get();
        
        $category_discounts = $this->category
                                ->discounts()
                                ->where('start_timestamp', '<=', date('Y-m-d'))
                                ->where('end_timestamp', '>=', date('Y-m-d'))
                                ->where('active', 1)
                                ->get();

        $discounts = $item_discounts->merge($category_discounts);
        $max_discount = $discounts->max('amount_percent');
        
        return $this->price * ((100-$max_discount) / 100);
    }
}
