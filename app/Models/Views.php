<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'ip_address',
        'session_id',
        'item_type',
        'item_id',
        'email',
        'marketing_tracking_code',
    ];
}
