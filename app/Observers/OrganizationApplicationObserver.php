<?php

namespace App\Observers;

use App\Enums\Organization\OrganizationApplicationStatus;
use App\Models\Organization\OrganizationApplication;
use App\Models\GeneralSetting;
use App\Notifications\OrganizationApplicationStatusNotification;

class OrganizationApplicationObserver
{
    /**
     * Handle the OrganizationApplication "updated" event.
     */
    public function updated(OrganizationApplication $organizationApplication): void
    {
        if ($organizationApplication->isDirty('collected_amount')) {
            $serviceChargePct = $organizationApplication->service_charge_pct ?? GeneralSetting::get('org_service_charge', 7.00);
            
            // Calculate net amount
            $collected = $organizationApplication->collected_amount;
            $serviceCharge = ($collected * $serviceChargePct) / 100;
            $netAmount = $collected - $serviceCharge;
            
            $organizationApplication->net_amount_payable = $netAmount;

            if ($organizationApplication->collected_amount >= $organizationApplication->requested_amount && $organizationApplication->status !== OrganizationApplicationStatus::COMPLETED->value) {
                $organizationApplication->status = OrganizationApplicationStatus::COMPLETED->value;
                
                $organizationApplication->saveQuietly();

                // Send completion notification
                if ($organizationApplication->user) {
                    $organizationApplication->user->notify(new OrganizationApplicationStatusNotification(
                        'Fundraising Goal Reached!',
                        "Congratulations! Your application '{$organizationApplication->title}' has reached its fundraising goal of Tk {$organizationApplication->requested_amount}.",
                        'application_completed',
                        $organizationApplication->id
                    ));
                }
            } else {
                $organizationApplication->saveQuietly();
            }
        }

        if ($organizationApplication->isDirty('status')) {
            $status = $organizationApplication->status;
            $body = "Your application status has been updated to: " . ucfirst($status);
            
            if ($status == OrganizationApplicationStatus::APPROVED->value) {
                $body = "Congratulations! Your application '{$organizationApplication->title}' has been approved and is now live for fundraising.";
            } elseif ($status == OrganizationApplicationStatus::REJECTED->value) {
                $body = "We regret to inform you that your application '{$organizationApplication->title}' has been rejected. Reason: " . ($organizationApplication->rejection_reason ?? 'N/A');
            }

            if ($organizationApplication->user) {
                $organizationApplication->user->notify(new OrganizationApplicationStatusNotification(
                    'Application Status Updated',
                    $body,
                    'status_update',
                    $organizationApplication->id
                ));
            }
        }
    }
}
