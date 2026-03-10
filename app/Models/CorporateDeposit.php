<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'transaction_id',
        'status',
        'cheque_no',
        'bank_name',
        'cheque_image',
        'admin_note',
    ];

    // Status constants
    const STATUS_PENDING       = 'pending';
    const STATUS_UNDER_REVIEW  = 'under_review';
    const STATUS_COMPLETED     = 'completed';
    const STATUS_REJECTED      = 'rejected';
    const STATUS_FAILED        = 'failed';
    const STATUS_CANCELLED     = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
