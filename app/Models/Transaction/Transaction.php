<?php

namespace App\Models\Transaction;

use App\Models\Bank\Bank;
use App\Models\Bank\BankAccount;
use App\Models\Campaign\Campaign;
use App\Models\Invoice\Invoice;
use App\Models\User;
use App\Models\User\UserBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_type',
        'date',
        'amount',
        'reference_number',
        'remarks',
        'status',
        'type',
        'sub_type',
        'campaign_id',
        'invoice_id',
        'transaction_category_id',
        'transaction_mode_id',
        'user_bank_id',
        'bank_id',
        'bank_account_id',
        'organization_application_id', // Added this line
        'volunteer_id',
        'donor_id',
        'created_by',
        'mobile',
        'name',
        'volunteer_payment_type',
        'receive_status',
    ];

    public function bankInfo(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function bankAccountInfo(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function campaignInfo(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function donorInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id', 'id');
    }

    public function volunteerInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'volunteer_id', 'id');
    }

    public function transactionCategory(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function transactionMode(): BelongsTo
    {
        return $this->belongsTo(TransactionMode::class);
    }

    public function userBank(): BelongsTo
    {
        return $this->belongsTo(UserBank::class);
    }
}
