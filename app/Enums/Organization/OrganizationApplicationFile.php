<?php

namespace App\Enums\Organization;

use App\Traits\Enumerrayble;

enum OrganizationApplicationFile: string
{
    use Enumerrayble;

    case AUTH_FILE = 'seeker_application_auth_file';

}
