<?php

namespace App\Observers;

use App\Http\Traits\Sms;
use App\Models\Campaign\Campaign;

class CampaignObserver
{
    use Sms;

    /**
     * Handle the Campaign "created" event.
     */
    public function created(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "updated" event.
     */
    public function updated(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "deleted" event.
     */
    public function deleted(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "restored" event.
     */
    public function restored(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "force deleted" event.
     */
    public function forceDeleted(Campaign $campaign): void
    {
        //
    }

    /**
     * Handle the Campaign "saved" event.
     */
    public function saved(Campaign $campaign): void
    {
        if ($campaign->status == 'finished') {
            $donations = $campaign->donations;

            foreach ($donations as $donation) {
                $message = <<<EOD
                The campaign(ID: {$campaign->sid})  has been successfully completed. Thank you for your contribution.
                
                Thank you,
                helpNhelper Support Team
                EOD;

                $donorMobile = $donation->phone != null ? $donation->phone : $donation->user->mobile;
                $this->smsSend($donorMobile, $message);
            }
        }
    }
}
