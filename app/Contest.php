<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    /*
    * Fillable columns in the table
    */
    protected $fillable = [
        'name',
        'slug',
        'photo_limit',
        'start_upload',
        'stop_upload',
        'start_vote',
        'stop_vote'];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
