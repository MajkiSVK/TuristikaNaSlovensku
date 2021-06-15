<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany('App\Photo');
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany('App\Like');
    }

    /**
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany('App\UserSetting');
    }

}
