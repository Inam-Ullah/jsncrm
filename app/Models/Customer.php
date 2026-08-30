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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function liveGraphs()
    {
        return $this->hasMany(LiveGraph::class, 'username', 'username');
    }

    public function dataUsagePeriods()
    {
        return $this->hasMany(DataUsagePeriod::class, 'username', 'username');
    }

    public function gracePeriods()
    {
        return $this->hasMany(GracePeriod::class);
    }

    public function staticIpAssignment()
    {
        return $this->hasOne(StaticIp::class);
    }

    public function quotaTracking()
    {
        return $this->hasOne(UserQuotaTracking::class);
    }

    public function usedPrepaidTokens()
    {
        return $this->hasMany(PrepaidToken::class, 'used_by_customer_id');
    }
}
