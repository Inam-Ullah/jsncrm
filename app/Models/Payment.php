<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_withdrawal' => 'boolean',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    public function pendingRequests()
    {
        return $this->hasMany(PendingPayment::class);
    }

    public function gatewayTransactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class);
    }

    public function cashFlows()
    {
        return $this->hasMany(CashFlow::class);
    }
}
