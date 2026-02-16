<?php

namespace App\Enums\Otp;

use App\Traits\Enumerrayble;

enum Purpose: string
{
    use Enumerrayble;

    case AUTHENTICATION = 'authentication';
    case VERIFICATION = 'verification';
    case RECOVERY = 'recovery';

}
