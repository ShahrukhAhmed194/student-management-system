<?php

namespace App\Console\Commands;

use App\Services\WebServices\TrialClassServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrialClassDailyReportMail;
use Carbon\Carbon;

class EmailTrialClassDailyReport extends Command
{
    protected $trial_class_services;

    protected $signature = 'scheduler:emailTrialClassDailyReport';

    protected $description = 'Command description';

    public function __construct()
    {
        $this->trial_class_services =  new TrialClassServices();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start_date = Carbon::now()->startOfMonth()->format('Y-m-01');
        $end_date = now()->format('Y-m-d');

        $trial_class_reports = $this->trial_class_services->getTrialClassDailyReport($start_date, $end_date);
        $upcomming_trial_classes = $this->trial_class_services->getUpcomingTrialClassReport();
        $cs_wise_trial_classes = $this->trial_class_services->getCSWiseTrialClassStatusReport();
        $intro_call_cs_reports = $this->trial_class_services->getIntroCallCSReport();

        $recipients = [ 'ashfaq@zamancpa.com', 'sharif.dreamers@gmail.com', 'arani.dreamers@gmail.com' ];

        Mail::to($recipients)->send(new TrialClassDailyReportMail(
            $trial_class_reports, $upcomming_trial_classes, $cs_wise_trial_classes, $intro_call_cs_reports
        ));

        $this->info('Trial class report sent successfully.');
        return 0;
    }
}
