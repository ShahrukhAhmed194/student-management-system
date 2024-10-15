<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\MakeWebService::class,
        Commands\MakeWebDao::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('scheduler:paymentpendingadmittedstudent')->dailyAt('06:00');
        $schedule->command('scheduler:dailyabsent')->dailyAt('16:00');
        //$schedule->command('scheduler:saveTrialClassNotificationReminder')->hourly();
    	//$schedule->command('scheduler:sendTrialClassNotficationReminder')->everyMinute();
    	$schedule->command('scheduler:dailyClassReminderScheduler')->dailyAt('03:30');
        $schedule->command('scheduler:salesReport')->dailyAt('17:00');
        //$schedule->command('scheduler:updateStudentClassNumber')->dailyAt('04:30');
        //$schedule->command('scheduler:dailyTrialClassReminderScheduler')->dailyAt('04:30');
        $schedule->command('scheduler:livesessionrecordingsavescheduler')->everyFiveMinutes();
        $schedule->command('scheduler:trialClassReminderTwiceADay')->twiceDaily(4, 14);
        $schedule->command('scheduler:setDueGraceValueToZero')->dailyAt('17:30');
        $schedule->command('scheduler:emailTrialClassDailyReport')->dailyAt('04:10');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
