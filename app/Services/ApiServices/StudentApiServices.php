<?php
namespace App\Services\ApiServices;

use Illuminate\Support\Facades\DB;
use App\Models\StudentTrialTimeline;

class StudentApiServices{

    public function getStudentProfileInfo($student_id){
        $reformed_data = array();
        $students = DB::select("SELECT 
        COUNT(CASE WHEN sa.status = '1' THEN 1 END) AS 'presents',
        COUNT(CASE WHEN sa.status = '0' THEN 1 END) AS 'absents',
        track.track_num AS track, levels.level_num AS level
        FROM students std
        JOIN da_classes dc ON (std.class_id = dc.id)
        JOIN course_tracks track ON (dc.track_id = track.id)
        JOIN course_levels levels ON (dc.level_id = levels.id)
        JOIN student_attendances sa ON (std.id = sa.student_id) 
        WHERE std.id = $student_id");

        foreach($students as $index => $student){
            $reformed_data[$index] = [
                "track" => $student->track,
                "level" => $student->level,
                "attendance" => [
                    "present" => $student->presents,
                    "absent" => $student->absents
                ],
                "skills" => ["Not Specified Yet"],
                "progress_tracker" => ["Not Specified Yet"]
            ];
        }
        return $reformed_data;
    }

    public function getStudentClassInfo($student_id){
        $reformed_data = array();
        $students =DB::select("SELECT u.name, dc.name as class_name, cs.session_date, cs.session_started, cs.status, cs.comments
        FROM students std
        JOIN users u ON (std.user_id = u.id)
        JOIN da_classes dc ON (std.class_id = dc.id)
        JOIN class_sessions cs ON (cs.class_id = dc.id)
        WHERE std.id = $student_id AND dc.status = 1");

        foreach($students as $index => $student){
            $reformed_data[$index] = array(
                "student_name" => $student->name,
                "class_name" => $student->class_name,
                "date" => $student->session_date,
                "time" => $student->session_started,
                "status"  => $student->status,         
                "comments"  => $student->comments
            );
        }

        return $reformed_data;
    }

    public function getStudentTrialTimeline($student_id){
        $trialTimeLineData = array();
        $getStudentTrialTimelineInfo = StudentTrialTimeline::where('student_id', $student_id)->first();

        $trialTimeLineData = array(
            'schedule' => array(
                'trial_date' => $getStudentTrialTimelineInfo->trialClass->schedule->date,
                'trial_time' => $getStudentTrialTimelineInfo->trialClass->schedule->time,
            ),
            'zoom_meeting_details' => array(
                'zoom_link' => (!empty($getStudentTrialTimelineInfo->trialClass->schedule->teacher->value_a) ? $getStudentTrialTimelineInfo->trialClass->schedule->teacher->value_a : ''),
                'meeting_id' => (!empty($getStudentTrialTimelineInfo->trialClass->schedule->teacher->zoom_meeting_id) ? $getStudentTrialTimelineInfo->trialClass->schedule->teacher->zoom_meeting_id : ''),
                'passcode' => (!empty($getStudentTrialTimelineInfo->trialClass->schedule->teacher->zoom_password) ? $getStudentTrialTimelineInfo->trialClass->schedule->teacher->zoom_password : ''),
            ),
            'instructions' => '',
            'timeline' => array(
                'registration_complete' => (!empty($getStudentTrialTimelineInfo->registration_complete) ? $getStudentTrialTimelineInfo->registration_complete : -1),
                'registration_complete_date' => (!empty($getStudentTrialTimelineInfo->registration_complete_date) ? $getStudentTrialTimelineInfo->registration_complete_date : ''),
                'registration_complete_time' => (!empty($getStudentTrialTimelineInfo->registration_complete_time) ? $getStudentTrialTimelineInfo->registration_complete_time : ''),
                'will_attend' => (!empty($getStudentTrialTimelineInfo->will_attend) ? $getStudentTrialTimelineInfo->will_attend : -1),
                'will_attend_date' => (!empty($getStudentTrialTimelineInfo->will_attend_date) ? $getStudentTrialTimelineInfo->will_attend_date : ''),
                'will_attend_time' => (!empty($getStudentTrialTimelineInfo->will_attend_time) ? $getStudentTrialTimelineInfo->will_attend_time : ''),
                'rescheduled' => (!empty($getStudentTrialTimelineInfo->rescheduled) ? $getStudentTrialTimelineInfo->rescheduled : -1),
                'rescheduled_date' => (!empty($getStudentTrialTimelineInfo->rescheduled_date) ? $getStudentTrialTimelineInfo->rescheduled_date : ''),
                'rescheduled_time' => (!empty($getStudentTrialTimelineInfo->rescheduled_time) ? $getStudentTrialTimelineInfo->rescheduled_time : ''),
                'attended' => (!empty($getStudentTrialTimelineInfo->attended) ? $getStudentTrialTimelineInfo->attended : -1),
                'attended_date' => (!empty($getStudentTrialTimelineInfo->attended_date) ? $getStudentTrialTimelineInfo->attended_date : ''),
                'attended_time' => (!empty($getStudentTrialTimelineInfo->attended_time) ? $getStudentTrialTimelineInfo->attended_time : ''),
                'refused_admission' => (!empty($getStudentTrialTimelineInfo->refused_admission) ? $getStudentTrialTimelineInfo->refused_admission : -1),
                'refused_admission_date' => (!empty($getStudentTrialTimelineInfo->refused_admission_date) ? $getStudentTrialTimelineInfo->refused_admission_date : ''),
                'refused_admission_time' => (!empty($getStudentTrialTimelineInfo->refused_admission_time) ? $getStudentTrialTimelineInfo->refused_admission_time : ''),
                'payment_complete' => (!empty($getStudentTrialTimelineInfo->payment_complete) ? $getStudentTrialTimelineInfo->payment_complete : -1),
                'payment_complete_date' => (!empty($getStudentTrialTimelineInfo->payment_complete_date) ? $getStudentTrialTimelineInfo->payment_complete_date : ''),
                'payment_complete_time' => (!empty($getStudentTrialTimelineInfo->payment_complete_time) ? $getStudentTrialTimelineInfo->payment_complete_time : ''),
                'admission_complete' => (!empty($getStudentTrialTimelineInfo->admission_complete) ? $getStudentTrialTimelineInfo->admission_complete : -1),
                'admission_complete_date' => (!empty($getStudentTrialTimelineInfo->admission_complete_date) ? $getStudentTrialTimelineInfo->admission_complete_date : ''),
                'admission_complete_time' => (!empty($getStudentTrialTimelineInfo->admission_complete_time) ? $getStudentTrialTimelineInfo->admission_complete_time : ''),
            ),
        );

        return $trialTimeLineData;
    }
}