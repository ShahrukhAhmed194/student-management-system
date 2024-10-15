<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrialClassConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $trialClass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trialClass)
    {
        $this->trialClass = $trialClass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Coding for Kids | Trial Class Details')->markdown('emails.trial-class-confirmation');
    }
}
