<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $otp;

    public function __construct(string $name, string $otp)
    {
        $this->name = $name;
        $this->otp  = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your MediLeaf password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password-otp',
        );
    }
}