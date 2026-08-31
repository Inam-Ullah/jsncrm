<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'sms_status' => 'boolean',
        'last_login_at' => 'datetime',
        'last_logout_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isp()
    {
        return $this->belongsTo(Isp::class);
    }

    public function ownedIsps()
    {
        return $this->hasMany(Isp::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(self::class, 'admin_id');
    }

    public function franchise()
    {
        return $this->belongsTo(self::class, 'franchise_id');
    }

    public function dealer()
    {
        return $this->belongsTo(self::class, 'dealer_id');
    }

    public function subdealer()
    {
        return $this->belongsTo(self::class, 'subdealer_id');
    }

    public function reseller()
    {
        return $this->belongsTo(self::class, 'reseller_id');
    }

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function city()
    {
        return $this->belongsTo(Area::class, 'city_id');
    }

    public function subarea()
    {
        return $this->belongsTo(Area::class, 'subarea_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function packagePrices()
    {
        return $this->hasMany(FPackage::class);
    }

    public function resellerPackagePrices()
    {
        return $this->hasMany(FPackage::class, 'reseller_id');
    }

    public function soldInvoices()
    {
        return $this->hasMany(Invoice::class, 'sold_by');
    }

    public function createdInvoices()
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    public function ledgerEntries()
    {
        return $this->hasMany(Ledger::class);
    }

    public function relatedLedgerEntries()
    {
        return $this->hasMany(Ledger::class, 'related_user_id');
    }

    public function actionedLedgerEntries()
    {
        return $this->hasMany(Ledger::class, 'action_by');
    }

    public function paymentsMade()
    {
        return $this->hasMany(Payment::class, 'payer_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    public function actionedPayments()
    {
        return $this->hasMany(Payment::class, 'action_by');
    }

    public function pendingPayments()
    {
        return $this->hasMany(PendingPayment::class);
    }

    public function pendingPaymentsReceived()
    {
        return $this->hasMany(PendingPayment::class, 'received_by');
    }

    public function actionedPendingPayments()
    {
        return $this->hasMany(PendingPayment::class, 'action_by');
    }

    public function actionedGatewayTransactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class, 'action_by');
    }

    public function createdGatewayTransactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class, 'created_by');
    }

    public function updatedGatewayTransactions()
    {
        return $this->hasMany(PaymentGatewayTransaction::class, 'updated_by');
    }

    public function cashFlowCategories()
    {
        return $this->hasMany(CashFlowCategory::class);
    }

    public function cashFlows()
    {
        return $this->hasMany(CashFlow::class);
    }

    public function ownedCashFlows()
    {
        return $this->hasMany(CashFlow::class, 'owner_id');
    }

    public function addedCashFlows()
    {
        return $this->hasMany(CashFlow::class, 'added_by');
    }

    public function actionedActivityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'action_by_id');
    }

    public function againstActivityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'against_user_id');
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(Document::class, 'uploaded_by_id');
    }

    public function verifiedDocuments()
    {
        return $this->hasMany(Document::class, 'verified_by_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function addedNotes()
    {
        return $this->hasMany(Note::class, 'added_by_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function markedAttendances()
    {
        return $this->hasMany(Attendance::class, 'marked_by_id');
    }

    public function coaRequests()
    {
        return $this->hasMany(CoaRequest::class);
    }

    public function createdCoaRequests()
    {
        return $this->hasMany(CoaRequest::class, 'created_by');
    }

    public function updatedCoaRequests()
    {
        return $this->hasMany(CoaRequest::class, 'updated_by');
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public function resellerPrepaidCards()
    {
        return $this->hasMany(PrepaidCard::class, 'reseller_id');
    }

    public function createdPrepaidCards()
    {
        return $this->hasMany(PrepaidCard::class, 'created_by');
    }

    public function createdPrepaidTokens()
    {
        return $this->hasMany(PrepaidToken::class, 'created_by');
    }

    public function soldPrepaidTokens()
    {
        return $this->hasMany(PrepaidToken::class, 'sales_person_id');
    }

    public function resellerTokenCards()
    {
        return $this->hasMany(TokenCard::class, 'reseller_id');
    }

    public function createdTokenCards()
    {
        return $this->hasMany(TokenCard::class, 'created_by');
    }

    public function soldAccessTokens()
    {
        return $this->hasMany(AccessToken::class, 'sales_person_id');
    }

    public function createdAccessTokens()
    {
        return $this->hasMany(AccessToken::class, 'created_by');
    }

    public function updatedAccessTokens()
    {
        return $this->hasMany(AccessToken::class, 'updated_by');
    }

    public function notificationTemplates()
    {
        return $this->hasMany(NotificationTemplate::class);
    }

    public function notificationMessages()
    {
        return $this->hasMany(NotificationMessage::class);
    }

    public function receivedNotificationMessages()
    {
        return $this->hasMany(NotificationMessage::class, 'recipient_user_id');
    }

    public function createdNotificationMessages()
    {
        return $this->hasMany(NotificationMessage::class, 'created_by_id');
    }
}
