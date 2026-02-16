<?php

namespace App\Enums\Volunteer;

use App\Traits\Enumerrayble;

enum VolunteerFile: string
{
    use Enumerrayble;

    case PROFILE_IMG = 'volunteer_profile_image';
    case AUTH_FILE = 'volunteer_auth_file';

}
