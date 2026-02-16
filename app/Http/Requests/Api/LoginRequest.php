<?php

namespace App\Http\Requests\Api;

use App\Models\Otp\Otp;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email' => ['required_without:mobile', 'email', 'nullable'],
            'mobile' => ['required_without:email', 'string', 'nullable'],
            'password' => ['required_without:otp', 'string', 'nullable'],
            'otp' => ['required_without:password', 'string', 'nullable'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return User $user
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): User
    {
        $this->ensureIsNotRateLimited();

        $contactType = $this->email ? 'email' : 'mobile';
        $authType = $this->password ? 'password' : 'otp';

        $contact = $this->email ?? $this->mobile;

        $user = User::where($contactType, $contact)->first();

        if (! $user || $user->email_verified_at == null) {
            return throw ValidationException::withMessages([
                'error' => ! $user ? 'User is unavailable.' : 'Verify your email first.',
            ]);
        }

        RateLimiter::hit($this->throttleKey());

        if ($authType == 'otp') {
            $otp = Otp::where('contact', $contact)->latest()->first();

            if ($this->otp !== $otp?->otp) {
                throw ValidationException::withMessages([
                    'otp' => 'Invalid OTP.',
                ]);
            }

            if ($otp?->used_at) {
                throw ValidationException::withMessages([
                    'otp' => 'This OTP is already used.',
                ]);
            }

            if (now()->gt($otp?->expires_at)) {
                throw ValidationException::withMessages([
                    'otp' => 'This OTP is already expired.',
                ]);
            }
            $otp->update(['used_at' => now()]);

        } else {

            if (! Hash::check($this->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => "Invalid {$contactType} or password.",
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());

        return $user;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower('login-attempt').'|'.$this->ip());
    }
}
