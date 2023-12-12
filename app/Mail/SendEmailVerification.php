<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Warehouse Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.warehouses',
            with: [
                'name' => $this->user->name,
                'code' => $this->user->verification_token
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
