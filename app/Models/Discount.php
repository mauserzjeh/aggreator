<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'amount_percent',
        'start_timestamp',
        'end_timestamp',
        'active'
    ];

    public function menu_items() {
        return $this->belongsToMany(MenuItem::class, 'discounts_menu_items', 'discount_id', 'menu_item_id');
    }

    public function menu_categories() {
        return $this->belongsToMany(MenuCategory::class, 'discounts_menu_categories', 'discount_id', 'menu_category_id');
    }
}
