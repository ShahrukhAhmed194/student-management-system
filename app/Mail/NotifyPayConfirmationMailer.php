<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class NotifyPayConfirmationMailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $payConfirmationContent;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->payConfirmationContent = $content;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject('Payment Confirmation')
                    ->view('emails.payConfirmationNotification')
                    ->with('payConfirmationContent', $this->payConfirmationContent);
    }
}
