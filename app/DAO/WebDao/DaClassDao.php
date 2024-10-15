<?php

namespace App\DAO\WebDao;

use App\Models\{DaClass};

class DaClassDao{
    
    public function fetchClassListUsingSearchParams($search_parameters)
    {
        $query = DaClass::select('da_classes.*', 'class_schedules.day', 'class_schedules.time')
                ->leftJoin('class_schedules', 'class_schedules.class_id', 'da_classes.id');

        if(count(array_diff($search_parameters, [null])) == 0){

            $query = $query->where('da_classes.status', 1);

        }else{

            if($search_parameters['day']){
                $query = $query->where('class_schedules.day', $search_parameters['day']);
            }
            if($search_parameters['time']){
                $query = $query->where('class_schedules.time', $search_parameters['time']);
            }
            if($search_parameters['track_num']){
                $query = $query->where('da_classes.track_num', $search_parameters['track_num']);
            }
            if(isset($search_parameters['status'])){
                $query = $query->where('da_classes.status', $search_parameters['status']);
            }
            
        }
            
        $classes = $query->groupBy('da_classes.name')->get();

        return $classes;
    }
}