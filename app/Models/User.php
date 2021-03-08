<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const TYPE_COURIER = 'courier';
    const TYPE_CUSTOMER = 'customer';
    const TYPE_MANAGER = 'manager';

    const TYPES = [
        self::TYPE_COURIER,
        self::TYPE_CUSTOMER,
        self::TYPE_MANAGER
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user type names
     * 
     * @return array
     */
    public static function get_type_names() {
        return [
            self::TYPE_COURIER => 'Courier',
            self::TYPE_CUSTOMER => 'Customer',
            self::TYPE_MANAGER => 'Manager'
        ];
    }

    /**
     * Get the name of the user type
     * 
     * @return string
     */
    public function get_type_name() {
        $type_names = self::get_type_names();
        return $type_names[$this->type];
    }

    /**
     * Name attribute mutator
     * 
     * @param string $name
     */
    public function setNameAttribute($name) {
        $this->attributes['name'] = trim($name);
    }

    /**
     * Email attribute mutator
     * 
     * @param string $email
     */
    public function setEmailAttribute($email) {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Password attribute mutator
     * 
     * @param string $password
     */
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

}
