<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    /*
     * Guarded column
     */
    protected $guarded = ['user_id'];

    /*
     * Relationship with user table
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
