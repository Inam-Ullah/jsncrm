<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GracePeriod extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'billing_amount' => 'decimal:2',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'previous_expiration_at' => 'datetime',
        'extended_expiration_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by_id');
    }
}
