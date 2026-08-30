<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
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

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function accessTokens()
    {
        return $this->hasMany(AccessToken::class);
    }
}
