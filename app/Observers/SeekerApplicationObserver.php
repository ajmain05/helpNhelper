<?php

namespace App\Observers;

use App\Http\Traits\Sms;
use App\Models\Seeker\SeekerApplication;

class SeekerApplicationObserver
{
    use Sms;

    /**
     * Handle the SeekerApplication "created" event.
     */
    public function created(SeekerApplication $seekerApplication): void
    {
        $seekerApplication->sid = 'SA-'. 100_000 + $seekerApplication->id;
        $seekerApplication->save();

        $seeker = $seekerApplication->user;

        $message = <<<EOD
        Your seeker application (ID: {$seekerApplication->sid}) has been successfully created.

        Thank you,
        helpNhelper Support Team
        EOD;
        $deliveryStatus = $this->smsSend($seeker->mobile, $message);
    }

    /**
     * Handle the SeekerApplication "updated" event.
     */
    public function updated(SeekerApplication $seekerApplication): void
    {
        //
    }

    /**
     * Handle the SeekerApplication "deleted" event.
     */
    public function deleted(SeekerApplication $seekerApplication): void
    {
        //
    }

    /**
     * Handle the SeekerApplication "restored" event.
     */
    public function restored(SeekerApplication $seekerApplication): void
    {
        //
    }

    /**
     * Handle the SeekerApplication "force deleted" event.
     */
    public function forceDeleted(SeekerApplication $seekerApplication): void
    {
        //
    }

    /**
     * Handle the SeekerApplication "saved" event.
     */
    public function saved(SeekerApplication $seekerApplication): void
    {
        if ($seekerApplication->status == 'rejected') {
            $seeker = $seekerApplication->user;
            $message = <<<EOD
            We regret to inform you that your seeker application(ID: {$seekerApplication->sid}) has been rejected.

            Thank you,
            helpNhelper Support Team
            EOD;
            $response = $this->smsSend($seeker->mobile, $message);
        } elseif ($seekerApplication->status == 'approved') {
            $seeker = $seekerApplication->user;
            $message = <<<EOD
            We are pleased to inform you that your Seeker application (ID: {$seekerApplication->sid}) has been approved.

            Thank you,
            helpNhelper Support Team
            EOD;
            $response = $this->smsSend($seeker->mobile, $message);
        } elseif ($seekerApplication->status == 'investigating') {
            $seeker = $seekerApplication->user;
            $message = <<<EOD
            Your seeker application (ID: {$seekerApplication->sid}) is currently under investigation.

            Thank you,
            helpNhelper Support Team
            EOD;
            $response = $this->smsSend($seeker->mobile, $message);
        }
    }
}
