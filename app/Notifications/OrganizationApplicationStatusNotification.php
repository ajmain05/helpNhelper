<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrganizationApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $type;
    protected $applicationId;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $body, $type, $applicationId)
    {
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
        $this->applicationId = $applicationId;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'application_id' => $this->applicationId,
        ];
    }
}
