<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nas extends Model
{
    protected $table = 'nas';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'checkedTime' => 'datetime',
    ];

    public function monitorings()
    {
        return $this->hasMany(NasMonitoring::class);
    }

    public function tokenCards()
    {
        return $this->hasMany(TokenCard::class);
    }

    public function accessTokens()
    {
        return $this->hasMany(AccessToken::class);
    }
}
