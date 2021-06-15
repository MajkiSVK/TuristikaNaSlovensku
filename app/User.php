<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'facebook_id', 'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'facebook_id',
    ];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function settings()
    {
        return $this->hasMany('App\UserSetting');
    }

}
