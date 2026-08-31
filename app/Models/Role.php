<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'permission_id' => 'integer',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
