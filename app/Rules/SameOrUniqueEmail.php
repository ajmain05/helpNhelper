<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class SameOrUniqueEmail implements ValidationRule
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
        // Get the current user's email
        $currentEmail = User::find($this->userId)->email;

        // Check if the email is the same as the current user's email

        // Check if the email is unique
        $isUnique = DB::table('users')->where('email', $value)->doesntExist();

        if (! $isUnique && $value !== $currentEmail) {
            $fail('The email must be either the same as your current email or unique.');
        }
    }
}
