<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\StudentAttendance;
use App\Models\StudentsParent;
use App\Models\User;
use Carbon\Carbon;

class DailyAbsentScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:dailyabsent';

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
    public function handle(){
        date_default_timezone_set("Asia/Dhaka");
        $today = date('Y-m-d');

        $todayAbsentStudents = StudentAttendance::with('student')
                        ->select('student_id')
                        ->where('status', 0)
                        ->where('date', $today)
                        ->get();
                        
        $contentData = [
                'subject' => '[ALERT] Daily Student Absent',
                'message' => "",
                'data'    => $todayAbsentStudents
            ];

        if(config('app.env') === 'production'){
            \Mail::to('dreamersacademy.xyz@gmail.com')
                ->bcc('adiba.dreamers@gmail.com')
                ->send(new \App\Mail\NotifyDailyAbsentMailer($contentData));
        }
        return 0;
    }
}
