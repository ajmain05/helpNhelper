<?php

namespace App\Observers;

use App\Http\Traits\Sms;
use App\Models\Donation;

class DonationObserver
{
    use Sms;

    /**
     * Handle the Donation "created" event.
     */
    public function creating(Donation $donation): void
    {
    }

    public function created(Donation $donation): void
    {
        $message = <<<EOD
        We are writing to confirm the receipt of your generous donation of BDT {$donation->amount} towards our campaign.
        
        Thank you,
        helpNhelper Support Team
        EOD;
        $this->smsSend($donation->phone, $message);
    }

    /**
     * Handle the Donation "updated" event.
     */
    public function updated(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "deleted" event.
     */
    public function deleted(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "restored" event.
     */
    public function restored(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "force deleted" event.
     */
    public function forceDeleted(Donation $donation): void
    {
        //
    }
}
