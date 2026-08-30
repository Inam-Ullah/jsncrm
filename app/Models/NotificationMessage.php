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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipientUser()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, 'notification_template_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function deliveries()
    {
        return $this->hasMany(NotificationDelivery::class);
    }
}
