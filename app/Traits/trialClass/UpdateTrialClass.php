<?php

namespace App\Traits\trialClass;

use Illuminate\Http\Request;
use App\Models\NoteUpdateHistory;
use App\Models\TrialClassSchedule;
use App\Models\StatusActionHistory;

trait UpdateTrialClass
{
    public function saveNoteHistory(Request $request){
        $note_history = new NoteUpdateHistory();
        $note_history->trial_class_id = $request->action_id;
        $note_history->note = $request->note;
        $note_history->user_id = auth()->user()->id;
        $note_history->save();

        toastr()->success('Note Added Successfully.');
    }

    public function updateRescheduledClassSeatNumber($schedule){
        $trial_schedule = TrialClassSchedule::find($schedule);
        $trial_schedule->available_seats = $trial_schedule->available_seats - 1;
        $trial_schedule->save();

        toastr()->success('Trial Class Rescheduled Successfully.');
    }

    public function saveActionHistory($status, $action_id){
        $actionStatus = new StatusActionHistory;
        $actionStatus->trial_class_id = $action_id;
        $actionStatus->status = $status;
        $actionStatus->user_id = auth()->user()->id;
        $actionStatus->date = date('Y-m-d', strtotime(Date(now())));
        $actionStatus->save();

        toastr()->success('Status History Added Successfully.');
    }

}