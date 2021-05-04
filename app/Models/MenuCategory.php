<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    public function items() {
        return $this->hasMany(MenuItem::class, 'menu_category_id', 'id');
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function discounts() {
        return $this->belongsToMany(Discount::class, 'discounts_menu_categories', 'menu_category_id', 'discount_id');
    }
}
