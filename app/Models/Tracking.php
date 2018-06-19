<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    public $timestamps = false;

    protected $table = 'tracking';

    /**
     * @var array
     */
    protected $fillable = [
        'session_id',
        'date',
        'type',
        'value',
    ];
}
