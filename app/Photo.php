<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /*
     * Fillable columns in the table
     */
    protected $fillable=['original_path','resized_path'];

    public function contest()
        {
            $this->belongsTo('App\Contest');
        }

    public function user()
        {
          $this->belongsTo('App\User');
        }
}
