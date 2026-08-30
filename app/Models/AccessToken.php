<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'status' => 'boolean',
        'expires_at' => 'datetime',
        'allow_multi_use' => 'boolean',
        'allow_other_nas' => 'boolean',
        'allow_multiple_mac' => 'boolean',
        'allow_multiple_ip' => 'boolean',
    ];

    public function tokenCard()
    {
        return $this->belongsTo(TokenCard::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
