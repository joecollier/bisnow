<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'html_body',
        'date'
    ];

    protected $table = 'news';
}
