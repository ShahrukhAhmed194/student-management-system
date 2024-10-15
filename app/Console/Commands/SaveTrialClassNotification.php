<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\TrialClassSchedule;
use App\Models\TrialClassNotify;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaveTrialClassNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:saveTrialClassNotificationReminder';

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

        $currentDate = Carbon::now()->format('Y-m-d');
        $trialClassSchedules = TrialClassSchedule::whereDate('date', $currentDate)
                                ->where('is_trial_class_notified', 0)
                                ->get();
        
        $scheduleStrtoTime = $beforeFifteenMin = $beforeThirtyMin = $beforeTwoHour = $beforeFourHour = $beforeSixHour = '';
        $beforeFifteenMinStrtotime = $beforeThirtyMinStrtotime = $beforeTwoHourStrtotime = $beforeFourHourStrtotime = $beforeSixHourStrtotime = '';

        foreach ($trialClassSchedules as $schedule) {
            $scheduleTime = $schedule->time;

            $scheduleStrtoTime = strtotime($scheduleTime);

            // --------------  Six Hour ------------------
            $beforeSixHourStrtotime = $scheduleStrtoTime-21600;
            $beforeSixHour = date('H:i', ($beforeSixHourStrtotime));

            // --------------  Four Hour ------------------
            $beforeFourHourStrtotime = $scheduleStrtoTime-14400;
            $beforeFourHour = date('H:i', ($beforeFourHourStrtotime));

            // --------------  Two Hour ------------------
            $beforeTwoHourStrtotime = $scheduleStrtoTime-7200;
            $beforeTwoHour = date('H:i', ($beforeTwoHourStrtotime));

            // --------------  Thirty Min ------------------
            $beforeThirtyMinStrtotime = $scheduleStrtoTime-1800;
            $beforeThirtyMin = date('H:i', ($beforeThirtyMinStrtotime));

            // --------------  Fifteen Min ------------------
            $beforeFifteenMinStrtotime = $scheduleStrtoTime-900;
            $beforeFifteenMin = date('H:i', ($beforeFifteenMinStrtotime));

             // --------------- its for exjact time -------------
            $this->saveTrialClassNotification($schedule->id, $scheduleTime);

            // --------------- its for before fifteen minute -------------
            $this->saveTrialClassNotification($schedule->id, $beforeFifteenMin);

            // --------------- its for before thirty minute -------------
            $this->saveTrialClassNotification($schedule->id, $beforeThirtyMin);

            // --------------- its for before Two Hour -------------
            $this->saveTrialClassNotification($schedule->id, $beforeTwoHour);

             // --------------- its for before Four Hour -------------
            $this->saveTrialClassNotification($schedule->id, $beforeFourHour);

             // --------------- its for before Six Hour -------------
            $this->saveTrialClassNotification($schedule->id, $beforeSixHour);

            TrialClassSchedule::where("id", $schedule->id)->update([
                "is_trial_class_notified" => 1,
            ]);
        }
        return 0;
    }

    // --------------- its for saveTrialClassNotification ----------------
    public function saveTrialClassNotification($schedule_id, $time){
        TrialClassNotify::create([
            'trial_class_sch_id' => $schedule_id,
            'notify_time' => $time,
        ]);
    }
}
