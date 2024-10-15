<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->data->from, 'Dreamers Academy')
            ->subject($this->data->subject)
            ->markdown('emails.generic');

        // if (!is_null($this->data->file)) {
        //     $mail->attach($this->data->file, [
        //         'as' => 'invoice.pdf',
        //         'mime' => 'application/pdf',
        //     ]);
        // }

        return $mail;
    }
}
