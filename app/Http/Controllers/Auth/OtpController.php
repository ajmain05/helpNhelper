<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\Sms;
use App\Mail\Auth\SendOtp;
use App\Models\User;
use App\Traits\Otp\HasOtp;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    use HasOtp, Sms;

    private const OTP_EXPIRY = 5 * 60; //5 minutes

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required_without:mobile', 'email', 'nullable', 'exists:users,email'],
            'mobile' => ['required_without:email', 'string', 'nullable', 'exists:users,mobile'],
        ]);
        $contactType = $request->email ? 'email' : 'mobile';
        $contact = $request->email ?: $request->mobile;

        $user = User::where($contactType, $contact)->firstOrFail();

        $lastOtpExpiry = $user->otps($contactType)->latest()->first()?->expires_at;

        if (
            $lastOtpExpiry &&
            ((now()->lt($lastOtpExpiry)))
        ) {
            $diffInSeconds = now()->diffInSeconds($lastOtpExpiry);
            $diffInSeconds = CarbonInterval::seconds($diffInSeconds)->cascade()->forHumans();

            return new JsonResponse(
                [
                    'message' => "Please wait {$diffInSeconds} before sending another otp.",
                ],
                Response::HTTP_OK
            );
        }

        $otp = $this->generateOtp();

        $otpMessage = <<<EOD
        Your OTP code is: {$otp}

        This code is valid for the next 5 minutes.

        Please do not share this code with anyone.

        Thank you,
        HelpNHelpers Support Team
        EOD;

        $user->otps($contactType)->create([
            'otp' => $otp,
            'contact_type' => $contactType,
            'created_at' => now(),
            'expires_at' => now()->addSeconds(self::OTP_EXPIRY),
        ]);

        if ($contactType === 'email') {
            Mail::to($user->email)->send(new SendOtp($user->name, $otp));
        }

        if ($contactType === 'mobile') {
            $deliveryStatus = $this->smsSend($user->mobile, $otpMessage);
        }

        return new JsonResponse(
            [
                'message' => $contactType === 'email' ? 'An OTP has been sent to your email.' : 'An OTP has been sent to your mobile.',
            ],
            Response::HTTP_OK
        );
    }
}
