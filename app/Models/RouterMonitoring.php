<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouterMonitoring extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function router()
    {
        return $this->belongsTo(Router::class);
    }
}
