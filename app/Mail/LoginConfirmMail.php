<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    const MAIL_SUBJECT = 'Xác nhận đăng nhập';

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected string $token;

    public function __construct(string $token)
    {
        $this->loginUrl = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(self::MAIL_SUBJECT)->view('mails.login-confirm');
    }
}
