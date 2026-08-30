<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDelivery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'provider_response' => 'array',
        'received_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(NotificationMessage::class, 'notification_message_id');
    }
}
