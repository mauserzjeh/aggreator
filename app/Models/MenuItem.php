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
}
