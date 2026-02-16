<?php

namespace App\Enums\Campaign;

use App\Traits\Enumerrayble;

enum Status: string
{
    use Enumerrayble;

    case Pending = 'pending';
    case Ongoing = 'ongoing';
    case Finished = 'finished';
    case Cancelled = 'cancelled';
}
