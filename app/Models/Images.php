<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    public function news() {
        return $this->belongsTo('App\News');
    }

    public function events() {
        return $this->belongsTo('App\Events');
    }
}
