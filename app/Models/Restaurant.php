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
}