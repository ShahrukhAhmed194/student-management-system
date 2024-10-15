<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Traits\SendMessage;
use App\Traits\WhatsAppNotification;

class DailyTrialClassReminderScheduler extends Command
{
    use WhatsAppNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:dailyTrialClassReminderScheduler';

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
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $today = date('Y-m-d');
        $getTrialClassesData = DB::select("SELECT trialClass.gurdian_name, trialClass.phone, trialClass.email, 
                trialClass.student_name, trialClass.status, trialClassSchedule.date, trialClassSchedule.time, 
                trialClassSchedule.teacher_id, users.name, users.class_login_details, users.value_a
                FROM trial_classes trialClass 
                JOIN trial_class_schedules trialClassSchedule ON trialClassSchedule.id = trialClass.trial_class_id
                JOIN users ON users.id = trialClassSchedule.teacher_id
                WHERE trialClass.status <> 'Invalid' AND trialClassSchedule.date = '$today' AND trialClassSchedule.status = 1");
            
            foreach ($getTrialClassesData as $value) {
                    $child_name = '"'.$value->student_name.'"';
                    $time = date('h:i A', strtotime($value->time));
    
                    $contentData = [
                        'subject' => '[ALERT] Coding Trial Class Reminder.',
                        'message' => "Your child ".$child_name. " has a Coding trial class Today.<br>
                            Date : $value->date <br>
                            Time : $time (Bangladesh Standard Time)<br>
                            Meeting Link: $value->value_a <br>
                            ",
                        'parentName'    => $value->gurdian_name,
                        'parentPhone'    => '',
                        'parentEmail'    => $value->email,
                    ];
                    
                    if(config('app.env') === 'production'){
                        if($value->email){
                            try {
                                \Mail::to($value->email)
                                ->send(new \App\Mail\NotifyReminderTrialClassMailer($contentData));
                            } catch (\Exception $e) {
                                
                            }   
                        }
                    
                        if($value->phone){
                            try {
                                $whatapp_msg = "Your child $child_name has a Coding trial class Today.
Date : $value->date
Time :  $time (Bangladesh Standard Time)
Meeting Link: $value->value_a
";
                                $this->sendWANotificationSecond($value->phone, $whatapp_msg);
                            } catch (\Exception $e) {
                                
                            } 
                        }
                    }
            }
        return 0;
    }
}
