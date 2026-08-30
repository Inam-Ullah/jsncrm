<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'secret',
    ];

    protected $casts = [
        'generate_pdf' => 'boolean',
        'status' => 'boolean',
        'used_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

}
