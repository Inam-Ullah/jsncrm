<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NasMonitoring extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }
}
