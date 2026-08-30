<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeRead extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function notice()
    {
        return $this->belongsTo(Notice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
