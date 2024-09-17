<?php

namespace App\Mail;

use App\Models\Newsletter;
use App\Settings\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $contact;
    public Newsletter $newsletter;

    /**
     * Create a new message instance.
     */
    public function __construct(string $contact, Newsletter $newsletter)
    {
        $this->contact = $contact;
        $this->newsletter = $newsletter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->newsletter->title, // Using dynamic subject from the newsletter
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter', // Make sure to create this Blade view
            with: [
                'newsletter' => $this->newsletter,
                'email' => $this->contact,
                'settings' => app(EmailSetting::class)
            ], // Pass data to the view
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
