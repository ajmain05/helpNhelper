<?php

namespace App\Http\Requests\Web\Auth;

use App\Models\Otp\Otp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required_without:mobile', 'email', 'nullable'],
            'mobile' => ['required_without:email', 'string', 'nullable'],
            'otp' => ['required_without:password', 'string', 'nullable'],
            'password' => ['required_without:otp', 'string', 'nullable'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $contactType = $this->email ? 'email' : 'mobile';
        $contact = $this->email ?: $this->mobile;
        $user = User::where($contactType, $contact)->first();
        if ($user == null) {
            return throw ValidationException::withMessages([
                'error' => 'User is unavailable',
            ]);
        }
        if ($user->email_verified_at == null) {
            return throw ValidationException::withMessages([
                'error' => 'Verify your email first',
            ]);
        }

        if ($this['auth-type'] == 'otp') {
            // $otp = Otp::whereContact($contact)->latest()->first();
            $otp = Otp::where('contact', $contact)->latest()->first();

            if (! $user || ($this->otp !== $otp->otp)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'otp' => 'Invalid OTP.',
                ]);
            }

            if ($otp?->used_at) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'otp' => 'This OTP is already used.',
                ]);
            }

            if (now()->gt($otp->expires_at)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'otp' => 'This OTP is already expired.',
                ]);
            }
            $otp->update(['used_at' => now()]);
            Auth::login($user, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());

            return $this->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
        } else {
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($this)) {
                $this->fireLockoutEvent($this);

                return $this->sendLockoutResponse($this);
            }

            if ($this->attemptLogin($this)) {
                if ($this->hasSession()) {
                    $this->session()->put('auth.password_confirmed_at', time());
                }

                return $this->sendLoginResponse($this);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($this);
        }

        return $this->sendFailedLoginResponse();
        //    return $user;
    }

    public function username()
    {
        return $this->email ? 'email' : 'mobile';
    }

    protected function sendFailedLoginResponse()
    {
        $contactType = $this->email ? 'email' : 'mobile';
        throw ValidationException::withMessages([
            $contactType => [trans('auth.failed')],
        ]);
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
        $contactType = $this->email ? 'email' : 'mobile';

        throw ValidationException::withMessages([
            $contactType => trans('auth.throttle', [
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
        $contactType = $this->email ? 'email' : 'mobile';

        return Str::transliterate(Str::lower($this->input($contactType)).'|'.$this->ip());
    }
}
