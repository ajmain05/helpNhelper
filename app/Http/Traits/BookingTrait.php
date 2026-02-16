<?php

namespace App\Http\Traits;

trait BookingTrait
{
    private $status = [
        'Pending' => 1,
        'Approved' => 2,
        'Cancelled' => 3,
    ];
}
