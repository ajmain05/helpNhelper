<?php

namespace App\Http\Traits;

trait LaundryTrait
{
    private $status = [
        'Pending' => 1,
        'Cancelled' => 2,
        'Accepted' => 3,
        'Completed' => 4,
        'Delivered' => 5,
    ];

    private $types = [
        'Wash' => 1,
        'Iron' => 2,
        'Wash & Iron' => 3,
    ];
}
