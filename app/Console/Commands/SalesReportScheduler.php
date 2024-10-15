<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DAO\WebDao\DaoForReports;
use Illuminate\Support\Facades\Mail;
use App\Traits\WhatsAppNotification;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\SendMail;
use Carbon\Carbon;
use URL;

class SalesReportScheduler extends Command
{
    use WhatsAppNotification;
    protected $dao_for_reports;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:salesReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dao_for_reports = new DaoForReports();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $receiverNumber = '+8801715438290';
        $receiverNumber2 = '+8801766939589';

        $fromDate = Carbon::now()->startOfMonth()->format('Y-m-01');
        $toDate = now()->format('Y-m-d');
        $salesUserReports = $this->dao_for_reports->fetchSalesCountForCSTeam($fromDate, $toDate);
        $reportsTotalSalesSum = $this->dao_for_reports->fetchSalesSumForCSTeam($fromDate, $toDate);
        
                        
        $contentData = [
                'subject' => "Sales Report $fromDate to $toDate",
                'message' => "",
                'data'    => $salesUserReports,
                'reportsTotalSalesSum'    => $reportsTotalSalesSum
            ];
        
        $contentDataPdf = PDF::loadView('emails.salesReportPdf', compact('contentData'));
        
        $pdfDownload = $contentDataPdf->download(public_path("pdf/salesReport/salesReport.pdf"));
        
        $baseUrl = URL::to('/');
        // Store the PDF on the server
        file_put_contents(public_path("pdf/salesReport/salesReport.pdf"), $pdfDownload);
        
        if(config('app.env') === 'production'){
		\Mail::to('dreamersacademy.xyz@gmail.com')
			->cc('arani.dreamers@gmail.com')
                ->bcc(['ashfaq@zamancpa.com'])
                ->send(new \App\Mail\NotifySalesReportMailer($contentDataPdf, $contentData));
	    
            $waAttachmentData = array(
                'attachmentName' => "salesReport.pdf",
                'attachment' => $baseUrl. ("/pdf/salesReport/salesReport.pdf"), //$contentDataPdf
	    );

            //$this->sendWAAttachment($receiverNumber, $waAttachmentData);
            //$this->sendWAAttachment($receiverNumber2, $waAttachmentData);
	    //$this->sendWAAttachment($receiverNumber, $waAttachmentData);
	    unlink(public_path("pdf/salesReport/salesReport.pdf"));
        }
        return 0;
    }
}
