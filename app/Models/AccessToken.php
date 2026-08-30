<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'status' => 'boolean',
        'expires_at' => 'datetime',
        'allow_multi_use' => 'boolean',
        'allow_other_nas' => 'boolean',
        'allow_multiple_mac' => 'boolean',
        'allow_multiple_ip' => 'boolean',
    ];

}
