<?php

namespace App\Models\Invoice;

use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'sid',
        'organization_application_id',
        'status',
        'date',
        'created_by',
    ];

    public function organizationApplication(): BelongsTo
    {
        return $this->belongsTo(OrganizationApplication::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'invoice_id', 'id');
    }

    public function statusInfo(): HasOne
    {
        return $this->hasOne(InvoiceStatus::class, 'id', 'status');
    }
}
