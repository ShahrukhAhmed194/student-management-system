<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class NotifyInstructorMailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $instructorContent;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->instructorContent = $content;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject('Trial Class Notification')
                    ->view('emails.trialClassNotification')
                    ->with('instructorContent', $this->instructorContent);
    }
}
