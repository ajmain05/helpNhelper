<?php

namespace App\Enums;

use App\Traits\Enumerrayble;

enum GlobalStatus: string
{
    use Enumerrayble;
    case Draft = 'draft';
    case Pending = 'pending';
    case Approved = 'approved';
    case Declined = 'declined';
    case Returned = 'returned';
    case Active = 'active';
    case Inactive = 'inactive';

}
