<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Traits\SendMessage;
use App\Traits\WhatsAppNotification;

class DailyClassReminderScheduler extends Command
{
    use WhatsAppNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:dailyClassReminderScheduler';

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
        $today = date('l');
        $getClassesData = DB::select("SELECT cs.class_id, cls.name, cs.day, cs.time, st.student_id, st.user_id, st.parent_id, 
                        studentUser.name as studentName, parentUser.name as parentName, parentUser.email as parentEmail, 
                        p.phone as parentPhone
                        FROM class_schedules cs
                        join da_classes cls on (cls.id = cs.class_id and cls.status = 1 and cls.teacher_id <> 3)
                        join students st on (st.class_id = cs.class_id)
                        join users studentUser on (studentUser.id = st.user_id)
                        join users parentUser on (parentUser.id = st.parent_id)
                        JOIN parents p on (p.user_id = st.parent_id)
                        where cs.day = '$today' AND st.status = 1 AND cls.notif_enable = 1
                        order by cs.class_id");
            
            foreach ($getClassesData as $value) {
                    $child_name = '"'.$value->studentName.'"';
                    $time = date('h:i A', strtotime($value->time));
    
                    $contentData = [
                        'subject' => '[ALERT] Coding Class Reminder.',
                        'message' => "Your child ".$child_name. " has a Coding class Today.<br>
                            Day : $value->day <br>
                            Time : $time (Bangladesh Standard Time)
                            ",
                        'parentName'    => $value->parentName,
                        'parentPhone'    => '',
                        'parentEmail'    => $value->parentEmail,
                    ];

                    if(config('app.env') === 'production'){
                        if($value->parentEmail){
                            try {
                                \Mail::to($value->parentEmail)
                                    ->send(new \App\Mail\NotifyDailyClassReminderMailer($contentData));
                            } catch (\Exception $e) {
                                
                            }   
                        }
                        
                        if($value->parentPhone){
                            try {
                                $whatapp_msg = "Your child $child_name has a Coding class Today.
Date : $value->day
Time :  $time (Bangladesh Standard Time)
";
                            $this->sendWANotificationSecond($value->parentPhone, $whatapp_msg);
                            } catch (\Exception $e) {
                                
                            }
                        }
                    }
            }
        return 0;
    }
}