<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'mail_password',
        'captcha_secret_key',
        'jazzcash_merchant_password',
        'jazzcash_integrity_salt',
        'easypaisa_hash_key',
        'nayapay_api_key',
        'nayapay_secret_key',
        'api_password',
        'whatsapp_access_token',
        'whatsapp_webhook_verify_token',
        'whatsapp_app_secret',
    ];

    protected $casts = [
        'vat' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'mail_password' => 'encrypted',
        'captcha_secret_key' => 'encrypted',
        'jazzcash_merchant_password' => 'encrypted',
        'jazzcash_integrity_salt' => 'encrypted',
        'easypaisa_hash_key' => 'encrypted',
        'nayapay_api_key' => 'encrypted',
        'nayapay_secret_key' => 'encrypted',
        'api_password' => 'encrypted',
        'whatsapp_access_token' => 'encrypted',
        'whatsapp_webhook_verify_token' => 'encrypted',
        'whatsapp_app_secret' => 'encrypted',
    ];

}
