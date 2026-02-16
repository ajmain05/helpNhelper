<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $signedUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($signedUrl)
    {
        $this->signedUrl = $signedUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
            from: new Address('helpnhelpers@support.com', 'HelpNHelper Support Team'),

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'v1.emails.verify',
            with: [
                'signedUrl' => $this->signedUrl,
            ]
        );
        // return $this->view('v1.emails.verify')
        // ->with(['signedUrl' => $this->signedUrl]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
