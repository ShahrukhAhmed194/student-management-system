<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMailer extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataSet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataSet)
    {
        $this->dataSet = $dataSet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
            ->subject($this->dataSet['subject'])
            ->view('emails.forgetPassword')
            ->with('contentData', $this->dataSet);
    }
}
