<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyParentsForTheirChildsTrialClass extends Mailable
{
    use Queueable, SerializesModels;

    public $parent_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->parent_content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject("[Reminder] Your Child's Coding Trial Class")
                    ->view('emails.trialClassRegistration')
                    ->with('parent_content', $this->parent_content);
    }
}