<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;

class StudentsClassNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id_list = Student::where('status', 1)->pluck('user_id')->toArray();
        $attendances = StudentAttendance::select('students.id', DB::raw('count(student_attendances.status) as classes'))
                    ->join('students', 'students.id', 'student_attendances.student_id')
                    ->whereIn('students.id', $id_list)
                    ->groupBy('students.id')
                    ->get();

        foreach($attendances as $index => $attendance){
            Student::where('id', $attendance->id)
                    ->update(['no_of_classes'=> $attendance->classes]);
        }
    }
}
