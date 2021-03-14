<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function restaurants() {
        return $this->belongsToMany(Restaurant::class, 'restaurant_tags_restaurants', 'restaurant_tag_id', 'restaurant_id');
    }

}
