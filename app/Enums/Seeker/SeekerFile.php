<?php

namespace App\Enums\Seeker;

use App\Traits\Enumerrayble;

enum SeekerFile: string
{
    use Enumerrayble;

    case PROFILE_IMG = 'seeker_profile_image';
    case AUTH_FILE = 'seeker_auth_file';

}
