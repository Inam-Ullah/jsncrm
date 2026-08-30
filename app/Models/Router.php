<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'api_enabled' => 'boolean',
        'api_password' => 'encrypted',
        'last_checked_at' => 'datetime',
        'status' => 'boolean',
    ];

}
