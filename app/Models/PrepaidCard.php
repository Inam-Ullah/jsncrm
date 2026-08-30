<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tokens()
    {
        return $this->hasMany(PrepaidToken::class);
    }
}
