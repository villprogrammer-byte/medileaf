<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $name;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $otp)
    {
        $this->name = $name;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Your MediLeaf Login Verification Code')
            ->view('emails.login-otp');
    }
}