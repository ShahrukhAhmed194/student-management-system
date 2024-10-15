<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentPayDueDate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::where('status', 1)->get();
        foreach($students as $student){
            $result = $student->no_of_classes % 8;
            if($student->no_of_classes > 8 && $result > 0){
                if($student->payment_status == 'Pending'){
                    $student->update(['due_date' => date('Y-m-d')]);
                }
            }
        }
    }
}
