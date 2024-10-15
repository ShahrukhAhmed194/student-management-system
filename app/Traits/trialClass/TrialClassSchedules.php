<?php

namespace App\Traits\trialClass;

use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use Carbon\Carbon;

trait TrialClassSchedules
{
    public function checkForExistingClasses(Request $request){
        $trial_class_day = Carbon::createFromFormat('Y-m-d', $request->date)->addHours(6)->format('l');
        $trial_class_time = $request->time;
        $trial_class_teacher_id = $request->teacher_id;
        
        $no_existing_class = ClassSchedule::where('teacher_id', $trial_class_teacher_id)
                        ->where('day', $trial_class_day)
                        ->where('time', $trial_class_time)
                        ->count();
        
        return $no_existing_class;
    }
}
