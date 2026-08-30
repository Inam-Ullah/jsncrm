<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FPackage extends Model
{
    use HasFactory;

    protected $table = 'f_packages';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
        'admin_profit' => 'decimal:2',
        'franchise_profit' => 'decimal:2',
        'dealer_profit' => 'decimal:2',
        'subdealer_profit' => 'decimal:2',
        'reseller_profit' => 'decimal:2',
        'customprice' => 'decimal:2',
        'extra_fee' => 'decimal:2',
        'vat' => 'decimal:2',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }
}
