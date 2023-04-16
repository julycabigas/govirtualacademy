<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role', 'firstname', 'lastname', 'phone', 'address', 'address_2', 'zipcode', 'municipality', 'about', 'role','expiration_date','image', 'password', 'show_profile', 'position'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function review()
    {
        return $this->hasMany('App\Review');
    }

    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }

    public function token()
    {
        return $this->hasMany('App\Token');
    }
    public function badges()
    {
        return $this->hasMany('App\StudentBadges');
    }
    public function trials()
    {
        return $this->hasOne('App\FreeTrial');
    }
}
