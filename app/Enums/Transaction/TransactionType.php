<?php

namespace App\Enums\Transaction;

use App\Traits\Enumerrayble;

enum TransactionType: string
{
    use Enumerrayble;

    case Income = 'income';
    case Expense = 'expense';
    case Both = 'both';
}
