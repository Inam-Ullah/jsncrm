<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by_id');
    }

    public function againstUser()
    {
        return $this->belongsTo(User::class, 'against_user_id');
    }

    public function target()
    {
        return $this->morphTo();
    }
}
