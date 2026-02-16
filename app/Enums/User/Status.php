<?php

namespace App\Enums\User;

use App\Traits\Enumerrayble;

enum Status: string
{
    use Enumerrayble;
    case Pending = 'pending';
    case Approved = 'approved';
    case Declined = 'declined';

}
