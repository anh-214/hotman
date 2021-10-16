<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
// class EmailResetPassword extends Mailable implements ShouldQueue
class EmailResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    protected $token;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $link)
    {   $this->email = $email;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.resetPassword',['email'=> $this->email,'link'=> $this->link])->subject('Reset mật khẩu');
    }
}
