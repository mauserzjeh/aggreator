<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergene extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug'
    ];

    public function menu_items() {
        return $this->belongsToMany(MenuItem::class, 'allergenes_menu_items', 'allergene_id', 'menu_item_id');
    }
}
