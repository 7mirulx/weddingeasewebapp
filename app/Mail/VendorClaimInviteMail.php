<?php

namespace App\Mail;

use App\Models\Vendor;
use App\Models\VendorClaimToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorClaimInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Vendor $vendor,
        public VendorClaimToken $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Claim Your Vendor Account - Jom Kahwin',
            to: [$this->vendor->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor-claim-invite',
            with: [
                'vendor' => $this->vendor,
                'claimUrl' => $this->vendor->getClaimUrl($this->token),
                'expiresAt' => $this->token->expires_at,
            ]
        );
    }
}
