<?php
namespace App\Services\ApiServices;

use App\Models\TrialClassSchedule;
use Illuminate\Http\Request;

class TrialClassScheduleApiServices{

    public function fetchTrialClassScheduleDates(Request $request){
        $payload = array();
        $trial_class_schedules = TrialClassSchedule::where('country', $request->country)
                    ->where('age_from', '<=', $request->age)
                    ->where('age_to', '>=', $request->age)
                    ->where('date', '>=', date('Y-m-d'))
                    ->where('available_seats', '>', 0)
                    ->where('status', 1)
                    ->orderBy('date', 'ASC')
                    ->groupBy('date')
                    ->get();
        if($trial_class_schedules && $trial_class_schedules != '[]'){
            foreach($trial_class_schedules as $index => $schedule){
                $reformed_data[$index] = array(
                    "id" => $schedule->id,
                    "date" => $schedule->date,
                );
            }
            $payload = [
                "date" => $reformed_data
            ];
        }
        return $payload;
    }

    public function fetchTrialClassScheduleTimes(Request $request){
        $payload = array();
        $trial_class_schedules = TrialClassSchedule::where('country', $request->country)
                    ->where('age_from', '<=', $request->age)
                    ->where('age_to', '>=', $request->age)
                    ->where('date', $request->date)
                    ->where('available_seats', '>', 0)
                    ->where('status', 1)
                    ->get();
        
        if($trial_class_schedules && $trial_class_schedules != '[]'){
            foreach($trial_class_schedules as $index => $schedule){
                $reformed_data[$index] = array(
                    "id" => $schedule->id,
                    "time" => date('h:i A', strtotime($schedule->time))
                );
            }
            $payload = [
                "time" => $reformed_data
            ];
        }
        return $payload;
    }
    
}