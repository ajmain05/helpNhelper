<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CorporateAllocationNotification extends Notification
{
    use Queueable;

    protected $amount;
    protected $campaignTitle;
    protected $remainingBalance;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($amount, $campaignTitle, $remainingBalance)
    {
        $this->amount = $amount;
        $this->campaignTitle = $campaignTitle;
        $this->remainingBalance = $remainingBalance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // For now using Database so it shows up in the App's notification tray/API. 
        // If mail or FCM was configured, it would be added here: ['database', 'mail', 'fcm']
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Fund Allocated!',
            'body' => "Tk {$this->amount} was successfully allocated to the '{$this->campaignTitle}' campaign. Your remaining wallet balance is Tk {$this->remainingBalance}.",
            'type' => 'corporate_allocation',
            'amount' => $this->amount,
            'campaign' => $this->campaignTitle,
            'balance' => $this->remainingBalance,
        ];
    }
}
