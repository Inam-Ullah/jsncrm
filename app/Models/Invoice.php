<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
        'previous_expiration_at' => 'datetime',
        'new_expiration_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'reseller_paid_amount' => 'decimal:2',
    ];

    public function isp()
    {
        return $this->belongsTo(Isp::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function soldBy()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
