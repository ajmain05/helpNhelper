<?php

namespace App\Enums\Transaction;

use App\Traits\Enumerrayble;

enum VolunteerPaymentType: string
{
    use Enumerrayble;

    case Survey = 'survey';
    case Implementation1stInstallment = 'implementation 1st installment';
    case Implementation2ndInstallment = 'implementation 2nd installment';
    case Implementation3rdInstallment = 'implementation 3rd installment';
    case Implementation4thInstallment = 'implementation 4th installment';
    case None = 'none';
}
