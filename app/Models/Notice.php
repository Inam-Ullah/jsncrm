<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function assignedToRole()
    {
        return $this->belongsTo(Role::class, 'assigned_to_role_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function reads()
    {
        return $this->hasMany(NoticeRead::class);
    }
}
