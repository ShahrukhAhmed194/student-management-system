<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class UpdateActivePaymentStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::where('id', '!=', 0)
                    ->where('status', 1)
                    ->get();
        foreach($students as $student){
            $student->active_payment = 1;
            $student->save();
        } 
    }
}
