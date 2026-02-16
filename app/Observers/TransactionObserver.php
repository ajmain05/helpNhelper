<?php

namespace App\Observers;

use App\Http\Traits\Sms;
use App\Models\Transaction\Transaction;

class TransactionObserver
{
    use Sms;

    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        if ($transaction->volunteer_payment_type && $transaction->volunteer_payment_type != 'none') {
            $campaign = $transaction?->campaignInfo;
            $message = <<<EOD
            You have received payment for the BDT {$transaction->volunteer_payment_type} of the campaign (ID: {$campaign?->sid}).
            
            Thank you,
            helpNhelper Support Team
            EOD;

            $volunteer = $transaction->campaignInfo?->seeker_application?->volunteers?->first();
            if ($volunteer?->mobile) {
                $this->smsSend($volunteer?->mobile, $message);
            }
        }
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
