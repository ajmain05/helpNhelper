<?php

namespace App\Enums\Finance;

use App\Traits\Enum\Enumerrayble;

enum ExpenseType: string
{
    use Enumerrayble;

    case Digital = 'digital';
    case Manual = 'manual';
}
