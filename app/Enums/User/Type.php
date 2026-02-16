<?php

namespace App\Enums\User;

use App\Traits\Enumerrayble;

enum Type: string
{
    use Enumerrayble;
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Moderator = 'moderator';
    case Seeker = 'seeker';
    case Volunteer = 'volunteer';
    case Donor = 'donor';
    case CorporateDonor = 'corporate-donor';
    case Organization = 'organization';
}
