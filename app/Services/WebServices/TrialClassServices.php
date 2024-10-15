<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{TrialClassDao};
use Carbon\Carbon;

class TrialClassServices{

    protected $trial_class_dao;

    public function __construct()
    {
        $this->trial_class_dao = new TrialClassDao();
    }

    public function getParameterDatas($request, $from)
    {
        $parametersData = array(
            'studentName' => (!empty($request->studentName) ? $request->studentName : NULL),
            'track' => (!empty($request->track) ? $request->track : NULL),
            'time' => (!empty($request->time) ? $request->time : NULL),
            'trial_id' => (!empty($request->trial_id) ? $request->trial_id : NULL),
            'from_date' => (!empty($request->from_date) ? $request->from_date : NULL),
            'to_date' => (!empty($request->to_date) ? $request->to_date : NULL),
            'applied_from_date' => (!empty($request->applied_from_date) ? $request->applied_from_date : NULL),
            'applied_to_date' => (!empty($request->applied_to_date) ? $request->applied_to_date : NULL),
            'country' => (auth()->user()->email ==  'admin@dreamersacademy.co.uk' ? 'United Kingdom' : (!empty($request->country) ? $request->country : NULL)),
            'status' => (!empty($request->status) ? array_values(request()->status) : NULL),
            'sales_user_id' => (!empty($request->sales_user_id) ? $request->sales_user_id : NULL),
            'coordinator_id' => (!empty($request->coordinator_id) ? $request->coordinator_id : NULL),
            'email' => (!empty($request->email) ? $request->email : NULL),
            'phone' => (!empty($request->phone) ? $request->phone : NULL),
            'from' => $from,
            'day' => (!empty($request->day) ? $request->day : NULL),
            'hasDevice' => (isset($request->hasDevice) ? $request->hasDevice : NULL),
        );
        
        if($parametersData['track'] == 1){

            $parametersData['from_age'] = 7;
            $parametersData['to_age'] = 8;

        }elseif($parametersData['track'] == 2){

            $parametersData['from_age'] = 9;
            $parametersData['to_age'] = 10;

        }elseif($parametersData['track'] == 3){
            
            $parametersData['from_age'] = 11;
            $parametersData['to_age'] = 16;

        }else{
            $parametersData['from_age'] = $parametersData['to_age'] = NULL;
        }

        return $parametersData;
    }

    public function checkIfAllTheParametersAreEmpty($parametersData)
    {
        if (empty($parametersData['studentName']) && 
            empty($parametersData['track']) && 
            empty($parametersData['time']) && 
            empty($parametersData['trial_id']) && 
            (empty($parametersData['from_date']) || empty($parametersData['to_date'])) && 
            (empty($parametersData['applied_from_date']) || empty($parametersData['applied_to_date'])) && 
            empty($parametersData['status']) && 
            empty($parametersData['country']) && 
            empty($parametersData['sales_user_id']) && 
            empty($parametersData['coordinator_id']) && 
            empty($parametersData['email']) && 
            empty($parametersData['phone']) && 
            empty($parametersData['hasDevice'])) {

            return true;
        }else{
            return false;
        }
    }

    public function getFilteredTrialClassListAfterSearch($parametersData)
    {
        
        $status_array = empty($parametersData['status']) ? [] :  array_values(request()->status);

        if (is_array($status_array) && count($status_array) > 0) {

            $status = implode("','", $status_array);
            $status = "'$status'";

        } else {
            $status = null;
        }
        
        $trial_classes = $this->trial_class_dao->fetchFilteredTrialClassListAfterSearch($parametersData, $status);
        
        return $trial_classes;
    }

    public function getTrialClassIdList($trial_classes)
    {
        $id_list = array();
        foreach($trial_classes as $key => $trial_class){
            $id_list[$key] = $trial_class->id;
        }

        return $id_list;
    }

    public function getParentsWhoseChildHasTrialClass()
    {
        $morning = Carbon::createFromTime(10, 0); 
        $night = Carbon::createFromTime(20, 0);
        $now = Carbon::now()->addHours(6);

        if ($now->hour == $morning->hour) {
            return $this->trial_class_dao->fetchParentsWhoseChildHasTrialClassToday();
        } elseif ($now->hour == $night->hour) {
            return $this->trial_class_dao->fetchParentsWhoseChildHasTrialClassTomorrow();
        }
    }

    public function getTrialClassDailyReport($start_date, $end_date)
    {
        return $this->trial_class_dao->fetchTrialClassDailyReport($start_date, $end_date);
    }

    public function getUpcomingTrialClassReport()
    {
        return $this->trial_class_dao->fetchUpcommingTrialClassReport();
    }

    public function getCSWiseTrialClassStatusReport()
    {
        return $this->trial_class_dao->fetchCSWiseTrialClassStatusReport();
    }

    public function getIntroCallCSReport()
    {
        return $this->trial_class_dao->fetchIntroCallCSReport();
    }
}
