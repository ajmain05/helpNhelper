<?php

namespace App\Enums\Organization;

use App\Traits\Enumerrayble;

enum OrganizationFile: string
{
    use Enumerrayble;

    case PROFILE_IMG = 'seeker_profile_image';
    case AUTH_FILE = 'seeker_auth_file';

}
