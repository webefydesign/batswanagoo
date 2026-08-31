<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $fromName;
    public $fromEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $fromName, $fromEmail)
    {
        $this->user = $user;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification',
        );
    }

    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
                    ->subject('Verify Your Email ' . $this->fromName)
                    ->view('emails.emailVerifaction')
                    ->with(['user' => $this->user]);
    }
}
