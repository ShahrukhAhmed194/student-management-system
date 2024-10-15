<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\TrialClassNotify;
use Illuminate\Support\Facades\DB;
use App\Traits\SendMessage;
use App\Traits\WhatsAppNotification;
use Carbon\Carbon;

class SendTrialClassNotification extends Command
{
     use WhatsAppNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:sendTrialClassNotficationReminder';

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

        $getNotifyTrialClass = DB::select("SELECT a.gurdian_name, a.phone, a.email, a.student_name, b.id, b.notify_time, c.date, c.time, d.class_login_details, d.value_a
            FROM trial_classes a 
            JOIN trial_class_notifies b ON b.trial_class_sch_id = a.trial_class_id 
            JOIN trial_class_schedules c ON c.id = b.trial_class_sch_id
            JOIN users d ON d.id = c.teacher_id
            ");
            $currentTime = date("H:i");
        foreach ($getNotifyTrialClass as $value) {
            if($value->notify_time == $currentTime){
                $notifyId = $value->id;
                $child_name = '"'.$value->student_name.'"';
                $time = date('h:i A', strtotime($value->time));

                $contentData = [
                    'subject' => '[ALERT] Coding Trial Class Reminder.',
                    'message' => "Your child ".$child_name. " has a Coding trial class.<br>
                        Date : $value->date <br>
                        Time : $time (Bangladesh Standard Time)<br>
                        Meeting Link: $value->value_a <br>
                        Meeting Details: $value->class_login_details <br>
                        ",
                    'parentName'    => $value->gurdian_name,
                    'parentPhone'    => $value->phone,
                    'parentEmail'    => $value->email,
              ];

                if($value->email){
                    if(config('app.env') === 'production'){
                        \Mail::to($value->email)
                            ->send(new \App\Mail\NotifyReminderTrialClassMailer($contentData));
                    }
                }

                if($value->phone){
                    $whatapp_msg = "Your child $child_name has a Coding trial class. Please, join the trial class on time..
Date : $value->date
Time :  $time (Bangladesh Standard Time)
Meeting Link: $value->value_a
Meeting Details: $value->class_login_details";
                    if(config('app.env') === 'production'){
                        $this->sendWANotificationSecond($value->phone, $whatapp_msg);
                    }
                }

                $notifyData = TrialClassNotify::where("id", "=", $notifyId);
                $notifyData->delete();
            }
        }
        return 0;
    }
}
