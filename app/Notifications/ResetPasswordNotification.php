<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * The password reset token.
     */
    public $token;

    /**
     * Create notification instance
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the mail message
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Reset Password')
            ->view('emails.reset-password', [
                'name' => $notifiable->name,
                'email' => $notifiable->email,
                'url' => $url
            ]);
    }
}