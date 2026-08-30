<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'provider_response' => 'array',
        'queued_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

}
