<?php

namespace App\Enums\Donor;

use App\Traits\Enumerrayble;

enum DonorFile: string
{
    use Enumerrayble;

    case PROFILE_IMG = 'donor_profile_image';
    case AUTH_FILE = 'donor_auth_file';

}
