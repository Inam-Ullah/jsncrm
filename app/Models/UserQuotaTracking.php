<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuotaTracking extends Model
{
    use HasFactory;

    protected $table = 'users_qt';

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
