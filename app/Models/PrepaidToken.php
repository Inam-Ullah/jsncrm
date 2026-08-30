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

    public function prepaidCard()
    {
        return $this->belongsTo(PrepaidCard::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function usedByCustomer()
    {
        return $this->belongsTo(Customer::class, 'used_by_customer_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }
}
