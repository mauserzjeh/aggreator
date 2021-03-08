<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    const TYPE_COURIER = 1;
    const TYPE_CUSTOMER = 2;
    const TYPE_MANAGER = 3;

    const TYPES = [
        self::TYPE_COURIER,
        self::TYPE_CUSTOMER,
        self::TYPE_MANAGER
    ];

    protected $fillable = [
        'name'
    ];

    /**
     * Get the users of the given type
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->hasMany(User::class, 'user_type_id', 'id');
    }
}
