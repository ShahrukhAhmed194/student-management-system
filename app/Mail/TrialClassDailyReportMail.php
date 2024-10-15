<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class TrialClassDailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $trial_class_reports, $upcomming_trial_classes, $cs_wise_trial_classes, $intro_call_cs_reports;

    public function __construct($trial_class_reports, $upcomming_trial_classes, $cs_wise_trial_classes, $intro_call_cs_reports)
    {
       $this->trial_class_reports = $trial_class_reports;
       $this->upcomming_trial_classes = $upcomming_trial_classes;
       $this->cs_wise_trial_classes = $cs_wise_trial_classes;
       $this->intro_call_cs_reports = $intro_call_cs_reports;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $daily_report_pdf = Pdf::loadView('documents.trialClassDailyReport', ['trial_class_reports' => $this->trial_class_reports])
                ->setPaper('a4', 'landscape');
        $upcomming_report_pdf = Pdf::loadView('documents.upcomingTrialClassReport', ['upcomming_trial_classes' => $this->upcomming_trial_classes])
                ->setPaper('a4', 'landscape');
        $cs_wise_report_pdf = Pdf::loadView('documents.csWiseTrialClassReport', ['cs_wise_trial_classes' => $this->cs_wise_trial_classes])
                ->setPaper('a4', 'landscape');
        $intro_call_cs_report = Pdf::loadView('documents.introCallCSReport', ['intro_call_cs_reports' => $this->intro_call_cs_reports])
                ->setPaper('a4', 'landscape');

        return $this->from($address = 'dreamersacademy.xyz@gmail.com', $name = 'Dreamers Academy')
                ->subject('Daily Trial Class Reports')
                ->view('emails.empty')
                ->attachData($daily_report_pdf->output(), 'Daily Trial Class Report.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->attachData($upcomming_report_pdf->output(), 'Upcomming Trial Class Report.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->attachData($cs_wise_report_pdf->output(), 'CS Wise Trial Class Report.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->attachData($intro_call_cs_report->output(), 'Intro Call CS Report.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
