<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'zip_code',
        'city',
        'address',
        'email',
        'phone',
        'mobile_phone',
        'description',
    ];

    public function tags() {
        return $this->belongsToMany(RestaurantTag::class, 'restaurant_tags_restaurants', 'restaurant_id', 'restaurant_tag_id');
    }

    public function schedule() {
        return $this->hasOne(RestaurantSchedule::class);
    }

    public function menu_categories() {
        return $this->hasMany(MenuCategory::class, 'restaurant_id', 'id');
    }

    public function menu_items() {
        return $this->hasMany(MenuItem::class, 'restaurant_id', 'id');
    }
}
