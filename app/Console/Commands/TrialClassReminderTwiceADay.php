<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WebServices\TrialClassServices;
use Illuminate\Support\Facades\Mail;
use App\Traits\WhatsAppNotification;
use App\Traits\messages\CronJobMessages;
class TrialClassReminderTwiceADay extends Command
{
    use WhatsAppNotification, CronJobMessages;
    protected $trial_class_services;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:trialClassReminderTwiceADay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This scheduler sends an email and whatsapp message as a reminder to all parents the previous day and the day of trial class.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TrialClassServices $trial_class_services)
    {
        $this->trial_class_services = $trial_class_services;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $parent_contents = $this->trial_class_services->getParentsWhoseChildHasTrialClass();
        if($parent_contents){
            foreach($parent_contents as $parent_content){
                Mail::to($parent_content->email)
                ->send(new \App\Mail\NotifyParentsForTheirChildsTrialClass($parent_content));
                
                $whatsapp_msg = $this->getWAMessageToNotifyParentForTrialClass($parent_content);
                $this->sendWANotificationSecond($parent_content->phone, $whatsapp_msg);
            }
        }
    }
}