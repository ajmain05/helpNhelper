<?php

namespace App\Enums\User;

use App\Traits\Enumerrayble;

enum UserRequestFile: string
{
    use Enumerrayble;

    case PROFILE_IMG = 'user_req_profile_image';
    case AUTH_FILE = 'user_req_auth_file';

}
