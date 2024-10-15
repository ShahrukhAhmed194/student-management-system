<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class StudentClassNumberScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:updateStudentClassNumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates the no of classes of a student daily';

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
        $student_ids = Student::where('status', 1)->pluck('user_id')->toArray();
        $id_list = implode(',', $student_ids);
    
        $attendances = DB::select("SELECT student_id, COUNT(status) as classes
                        FROM student_attendances
                        where student_id in (".$id_list.")
                        group by student_id");

        foreach($attendances as $attendance){
            Student::where('user_id', $attendance->student_id)
                    ->update(['no_of_classes'=> $attendance->classes]);
        }

        return 0;
    }
}
