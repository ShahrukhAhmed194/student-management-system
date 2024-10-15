<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentNoteHistories;
use App\Models\Student;
use App\Models\User;

class UpdateStudentNotes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::whereNotNull('students_note')->get();
        $user = User::where('email', 'admin@gmail.com')->first();

        foreach($students as $student){
            $note_history = new StudentNoteHistories();
            $note_history->student_id = $student->id;
            $note_history->note = $student->students_note;
            $note_history->submitter_id = $user->id;
            $note_history->save();
        }
    }
}
