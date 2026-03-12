<?php

namespace App\Providers;

use App\Models\Campaign\Campaign;
use App\Models\Donation;
use App\Models\Invoice\Invoice;
use App\Models\Organization\OrganizationApplication;
use App\Models\Seeker\SeekerApplication;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Observers\CampaignObserver;
use App\Observers\DonationObserver;
use App\Observers\InvoiceObserver;
use App\Observers\OrganizationApplicationObserver;
use App\Observers\SeekerApplicationObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::observe(InvoiceObserver::class);
        Donation::observe(DonationObserver::class);
        Campaign::observe(CampaignObserver::class);
        SeekerApplication::observe(SeekerApplicationObserver::class);
        Transaction::observe(TransactionObserver::class);
        User::observe(UserObserver::class);
        OrganizationApplication::observe(OrganizationApplicationObserver::class);
    }
}
