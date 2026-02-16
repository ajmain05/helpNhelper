<?php

namespace App\Enums\Transaction;

use App\Traits\Enumerrayble;

enum ReceiverType: string
{
    use Enumerrayble;

    case Donor = 'donor';
    case CorporateDonor = 'corporate-donor';
    case Anonymous = 'anonymous';
}
