<?php

namespace App\Enums\Seeker;

use App\Traits\Enumerrayble;

enum SeekerApplicationFile: string
{
    use Enumerrayble;

    case AUTH_FILE = 'seeker_application_auth_file';

}
