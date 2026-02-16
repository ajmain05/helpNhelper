<?php

namespace App\Enums\Seeker;

use App\Traits\Enumerrayble;

enum SeekerApplicationStatus: string
{
    use Enumerrayble;

    case APPROVED = 'approved';
    case PENDING = 'pending';
    case INVESTIGATING = 'investigating';
    case REJECTED = 'rejected';

}
