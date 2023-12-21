<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
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
            markdown: 'emails.code',
            with: [
                'code' => $this->code,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
