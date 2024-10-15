<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class NotifyParentMailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $parentContent;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->parentContent = $content;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject('Trial Class Registration Confirmation')
                    ->view('emails.trialClassRegistration')
                    ->with('parent_content', $this->parentContent);
    }
}
