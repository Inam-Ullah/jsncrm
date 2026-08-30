<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataUsagePeriod extends Model
{
    protected $table = 'data_usage_by_period';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'period_start' => 'datetime',
        'period_end' => 'datetime',
    ];

}
