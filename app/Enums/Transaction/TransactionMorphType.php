<?php

namespace App\Enums\Transaction;

use App\Traits\Enumerrayble;

enum TransactionMorphType: string
{
    use Enumerrayble;

    case Sender = 'sender';
    case Receiver = 'receiver';
}
