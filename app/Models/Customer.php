<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_quota_expired' => 'boolean',
        'mac_lock' => 'boolean',
        'activation_date' => 'datetime',
        'renew_date' => 'datetime',
        'last_login_time' => 'datetime',
        'last_logout_time' => 'datetime',
        'last_expiration_date' => 'datetime',
        'current_expiration_date' => 'datetime',
        'last_profile_visit_time' => 'datetime',
    ];

}
