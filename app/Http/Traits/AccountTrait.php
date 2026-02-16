<?php

namespace App\Http\Traits;

trait AccountTrait
{
    private $sectors = [
        'Resident' => 1,
        'Organization' => 2,
        'Staff' => 3,
    ];

    private $types = [
        'Income' => 1,
        'Expense' => 2,
    ];
}
