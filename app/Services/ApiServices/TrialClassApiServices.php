<?php
namespace APP\Services\ApiServices;

use App\Models\TrialClassSchedule;
use App\Traits\Api\V1\TrialClassTimelineTrait;
use App\Models\StudentsParent;


class TrialClassApiServices{

    use TrialClassTimelineTrait;

    public function fetchUpcomingTrialClasses(){
        
        $reformed_data =array();
        $upcoming_trial_classes = TrialClassSchedule::where('date', '>=', date('Y-m-d'))
            ->where('available_seats', '>', 0)
            ->where('status', 1)
            ->orderBy('date', 'ASC')
            ->first();
        if($upcoming_trial_classes && $upcoming_trial_classes != '[]'){
                $reformed_data = array(
                    "date" => $upcoming_trial_classes->date,
                    "time" => $upcoming_trial_classes->time,
                    "details" => "This is a FREE 1 hour Coding class where your child will be introduced to the world of coding. The 1 hour will be filled with engaging projects, awesome coding mates and a caring and skilled  instructor. The whole 1 hour will be a wow experience for your child."
                );
        }
        
        return $reformed_data;
    }

    public function fetchTrialClassDetails($user_id){
        $payload = array();
        $trials = TrialClassSchedule::where('teacher_id', $user_id)
                ->where('status', 1)
                ->get();
        
        if($trials && $trials != '[]'){
            foreach($trials as $index => $trial){
                $reformed_data[$index] = array(
                    "date" => $trial->date,
                    "time" => $trial->time,
                    "zoom_link" => $trial->teacher->value_a,
                    "meeting_details" => $trial->class_login_details,
                    "instructions" => "Not Specified Yet"
                );
            }
            $payload = [
                "schedule" => $reformed_data,
                "timelines" => $this->fetchUsersTrialClassTimeline($user_id)
            ];
        }

        return $payload;
    }

    public function getTrialClassScheduleDate($age, $country){
        $payload = array();
        $query = TrialClassSchedule::select('id', 'age_from', 'age_to', 'date', 'time')
                ->where('age_from', '<=', $age)
                ->where('age_to', '>=', $age);
            if($country == 'India'){
                $query = $query->where('country', 'India');

            }elseif($country == 'United Kingdom'){
                $query = $query->where('country', 'United Kingdom');
                
            }else{
                $query = $query->where('country', 'Bangladesh');
            }
            $query = $query->where('date', '>=', now()->toDateString())
                    ->where('status', 1)
                    ->where('available_seats', '>', 0)
                    ->groupBy('date')
                    ->orderBy('date', 'ASC');
        $available_dates = $query->get();

        $payload = [
            "date" => $available_dates
        ];

        return $payload;
    }


    public function getTrialClassScheduleTime($age, $country, $date){
        $payload = array();

         if ($date) {
            $query = TrialClassSchedule::where('date', $date)
                ->where('age_from', '<=', $age)
                ->where('age_to', '>=', $age);
                if($country == 'India'){
                    $query->where('country', 'India');
                }elseif($country == 'United Kingdom'){
                    $query->where('country', 'United Kingdom');
                }else{
                    $query->where('country', 'Bangladesh');
                }
                $query->where('status', 1)
                ->where('available_seats', '>', 0);
                $available_times = $query->get();

                $payloadData = array(
                    'time' => $available_times,
                );
                return $payload;
        }
    }

    public function getParentInfo(StudentsParent $parent){
        $parentInfo = array(
            'name' => $parent->user->name,
            'phone_number' => $parent->phone,
            'email' => $parent->user->email,
        );
        $payload = array(
            'parent' => $parentInfo,
        );

        return $payload;
    }
    
}