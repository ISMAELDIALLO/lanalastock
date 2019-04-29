<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RepondreGestionnaire extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sub;
    public $mess;
    public function __construct($message, $subject)
    {
        $this->sub = $subject;
        $this->mess = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_message = $this->mess;

        $e_subject = $this->sub;

        return $this->view('mails.repondGestionnaire',compact('e_message'))->subject($e_subject);
    }
}
