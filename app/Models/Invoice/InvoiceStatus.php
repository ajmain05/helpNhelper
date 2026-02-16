<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use HasFactory;

    protected $table = 'invoice_statuses';

    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];
}
