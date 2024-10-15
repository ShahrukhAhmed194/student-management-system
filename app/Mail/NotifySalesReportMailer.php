<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class NotifySalesReportMailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $contentPdfData;
    public $contentData;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contentPdf, $contentData)
    {
        $this->contentPdfData = $contentPdf;
        $this->contentData = $contentData;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        
        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                    ->subject($this->contentData['subject'])
                    ->view('emails.salesReport')
                    ->with('data', $this->contentPdfData)
                    ->attachData($this->contentPdfData->output(), 'Sales Report.pdf');
    }
}
