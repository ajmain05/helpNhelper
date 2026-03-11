<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefundAllocationNotification extends Notification
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
            'title' => 'Fund Refunded!',
            'body' => "Tk {$this->amount} allocated to the '{$this->campaignTitle}' campaign has been refunded to your wallet. Your new wallet balance is Tk {$this->remainingBalance}.",
            'type' => 'refund_allocation',
            'amount' => $this->amount,
            'campaign' => $this->campaignTitle,
            'balance' => $this->remainingBalance,
        ];
    }
}
