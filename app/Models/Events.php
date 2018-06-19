<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    public function images(){
        return $this->hasMany('App\Images');
    }
}
