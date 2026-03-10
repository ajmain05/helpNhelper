<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChequeDepositStatusNotification extends Notification
{
    use Queueable;

    public string $status;
    public float  $amount;
    public ?string $adminNote;

    public function __construct(string $status, float $amount, ?string $adminNote = null)
    {
        $this->status    = $status;
        $this->amount    = $amount;
        $this->adminNote = $adminNote;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusLabel = $this->status === 'completed' ? 'Approved ✅' : 'Rejected ❌';

        $message = $this->status === 'completed'
            ? "Your cheque deposit of ৳" . number_format($this->amount, 2) . " has been approved and credited to your wallet."
            : "Your cheque deposit of ৳" . number_format($this->amount, 2) . " was rejected." .
              ($this->adminNote ? " Reason: {$this->adminNote}" : "");

        return [
            'type'       => 'cheque_deposit_status',
            'status'     => $this->status,
            'label'      => $statusLabel,
            'amount'     => $this->amount,
            'admin_note' => $this->adminNote,
            'message'    => $message,
        ];
    }
}
