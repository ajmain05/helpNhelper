<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignSuccessNotification extends Notification
{
    use Queueable;

    protected $campaignTitle;
    protected $allocatedAmount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($campaignTitle, $allocatedAmount)
    {
        $this->campaignTitle = $campaignTitle;
        $this->allocatedAmount = $allocatedAmount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
            'title' => 'Campaign Completed Successfully!',
            'body' => "The campaign '{$this->campaignTitle}' you supported with Tk {$this->allocatedAmount} has been successfully completed. Thank you for your contribution!",
            'type' => 'campaign_success',
            'campaign' => $this->campaignTitle,
            'amount' => $this->allocatedAmount,
        ];
    }
}
