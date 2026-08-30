<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'session_based' => 'boolean',
        'data_quota_enabled' => 'boolean',
        'fup_enabled' => 'boolean',
        'session_quota_enabled' => 'boolean',
        'user_self_activation' => 'boolean',
        'auto_payment' => 'boolean',
        'auto_renew' => 'boolean',
        'custom_expiry_enabled' => 'boolean',
        'left_over_volumes' => 'boolean',
        'left_over_sessions' => 'boolean',
        'invoice_volume_status' => 'boolean',
        'apply_users' => 'boolean',
        'apply_resellers' => 'boolean',
        'dynamic_bandwidth_enabled' => 'boolean',
    ];

}
