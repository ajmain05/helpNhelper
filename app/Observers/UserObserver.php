<?php

namespace App\Observers;

use App\Enums\User\Type;
use App\Http\Traits\Sms;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserObserver
{
    use Sms;

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($user->type == Type::Donor->value) {
            $user->update([
                'sid' => 'dUserID-'. 100_000 + $user->id,
            ]);
        } elseif ($user->type == Type::Seeker->value) {
            $user->update([
                'sid' => 'sUserID-'. 100_000 + $user->id,
            ]);
        } elseif ($user->type == Type::Volunteer->value) {
            $user->update([
                'sid' => 'vUserID-'. 100_000 + $user->id,
            ]);
        } elseif ($user->type == Type::Organization->value) {
            $user->update([
                'sid' => 'oUserID-'. 100_000 + $user->id,
            ]);
        } elseif ($user->type == Type::CorporateDonor->value) {
            $user->update([
                'sid' => 'cdUserID-'. 100_000 + $user->id,
            ]);
        }

        $hash = sha1($user->getEmailForVerification());
        $signedUrl = URL::signedRoute(
            'custom.verification.verify',
            ['id' => $user->id, 'hash' => $hash],
        );

        Mail::to($user->email)->send(new VerificationEmail($signedUrl));

        $message = <<<EOD
        Your account has been successfully created. Please verify the email to complete the registration.
        Click here: {$signedUrl}

        Thank you,
        helpNhelper Support Team
        EOD;
        $response = $this->smsSend($user->mobile, $message);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
