<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class NotifyReminderTrialClassMailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $dataContent;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->contentData = $content;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject($this->contentData['subject'])
                    ->view('emails.notifyReminderTrialclass')
                    ->with('contentData', $this->contentData);
    }
}
