<?php

namespace App\Traits\Api\V1;

use Illuminate\Support\Facades\DB;


trait TrialClassTimelineTrait
{
    public function fetchUsersTrialClassTimeline($user_id){
        $timelines = DB::select("SELECT users.name, timeline.registration_completed, timeline.will_attend_confirmation, timeline.trial_class_attended, timeline.payment_done, timeline.admission_confirmed
                     FROM trial_Class_timelines timeline
                     JOIN users ON (timeline.user_id = users.id)
                     JOIN trial_class_schedules schedule ON (schedule.id = timeline.trial_class_id)
                     WHERE schedule.teacher_id = $user_id");
        return $timelines;
    }
}