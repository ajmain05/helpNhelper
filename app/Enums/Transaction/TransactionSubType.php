<?php

namespace App\Enums\Transaction;

use App\Traits\Enumerrayble;

enum TransactionSubType: string
{
    use Enumerrayble;

    case General = 'general';
    case Campaign = 'campaign';
    case Digital = 'digital';
    case Manual = 'manual';
}
