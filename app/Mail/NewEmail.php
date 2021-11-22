<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $title, string $content)
    {   $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.newEmail',['content'=> $this->content])->subject($this->title);
    }
}
