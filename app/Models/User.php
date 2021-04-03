<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id'
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
     * Get the user type model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function type() {
        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
    }

    /**
     * Get the restaurant of the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function restaurant() {
        return $this->hasOne(Restaurant::class, 'user_id', 'id');
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
