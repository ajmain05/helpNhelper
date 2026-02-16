<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class SameOrUniqueMobile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currentMobile = User::find($this->userId)->mobile;

        // Check if the mobile is the same as the current user's mobile

        // Check if the mobile is unique
        $isUnique = DB::table('users')->where('mobile', $value)->doesntExist();

        if (! $isUnique && $value !== $currentMobile) {
            $fail('The mobile must be either the same as your current mobile or unique.');
        }
    }
}
