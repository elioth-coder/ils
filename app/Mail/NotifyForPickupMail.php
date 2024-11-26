<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyForPickupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // This makes $data available in the view

    public function __construct($data)
    {
        // Assigning passed data to the public property
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.notify-for-pickup')
                    ->with('data', $this->data); // Explicitly passing $data to the view
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification: Approved Request for Book Pickup',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notify-for-pickup',
        );
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
