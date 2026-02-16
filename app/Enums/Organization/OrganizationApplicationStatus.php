<?php

namespace App\Enums\Organization;

use App\Traits\Enumerrayble;

enum OrganizationApplicationStatus: string
{
    use Enumerrayble;

    case APPROVED = 'approved';
    case PENDING = 'pending';
    case INVESTIGATING = 'investigating';
    case REJECTED = 'rejected';

}
