<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class rejetterFacture extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mess;
    public $sub;
    public function __construct($message , $subject)
    {
        $this->mess = $message;
        $this->sub = $subject;
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

        return $this->view('mails.rejetterFacture',compact('e_message'))->subject($e_subject);
    }
}
