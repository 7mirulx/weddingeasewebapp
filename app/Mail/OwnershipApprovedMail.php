<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OwnershipApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Vendor Account Approved - Jom Kahwin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ownership-approved',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]
        );
    }
}
