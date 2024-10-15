<?php

namespace App\Traits\students;

use Illuminate\Http\Request;
use App\Models\StudentNoteHistories;

trait UpdateStudentInfo
{
    public function saveStudentNoteHistory(Request $request, $id){
        $note_history = new StudentNoteHistories();
        $note_history->student_id = $id;
        $note_history->note = $request->students_note;
        $note_history->submitter_id = auth()->user()->id;
        $note_history->save();

        toastr()->success('Note Added Successfully.');
    }
}