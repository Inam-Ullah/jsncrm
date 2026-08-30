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

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function bandwidthSchedules()
    {
        return $this->hasMany(PackageBandwidthSchedule::class)->orderBy('sort_order');
    }

    public function prices()
    {
        return $this->hasMany(FPackage::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function gatewayTransactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class);
    }

    public function prepaidCards()
    {
        return $this->hasMany(PrepaidCard::class);
    }

    public function tokenCards()
    {
        return $this->hasMany(TokenCard::class);
    }

    public function accessTokens()
    {
        return $this->hasMany(AccessToken::class);
    }

    public function notificationMessages()
    {
        return $this->hasMany(NotificationMessage::class);
    }
}
