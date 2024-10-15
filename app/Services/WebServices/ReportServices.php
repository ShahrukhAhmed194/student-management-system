<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{DaoForReports, StudentDao, TrialClassDao, TrialClassCallHistoriesDao, ClassRecordingDao};

class ReportServices{

    protected $report_dao, $student_dao, $trial_class_dao, $trial_class_call_histories_dao, $class_recording_dao;

    public function __construct()
    {
        $this->report_dao = new DaoForReports();
        $this->student_dao = new StudentDao();
        $this->trial_class_dao = new TrialClassDao();
        $this->trial_class_call_histories_dao = new TrialClassCallHistoriesDao();
        $this->class_recording_dao = new ClassRecordingDao();
    }

    public function getParamsForTrialClassReport($request)
    {
        return [
            'start_date' => $request->start_date ?? NULL,
            'end_date' => $request->end_date ?? NULL
        ];
    }

    public function getStudentCountByInstructor($search_params)
    {
        return $this->report_dao->fetchStudentCountOfTeacher($search_params);
    }

    public function getParentDetailsOfEachTrialClassRegistration($search_params)
    {
        return $this->report_dao->fetchParentDetailsOfEachTrialClassRegistration($search_params);
    }

    public function getStudentsMonthlyReport($request)
    {
        $start_date = $end_date = NULL;

        if($request->start_month && $request->end_month){
            $start_date = date('Y-m-d', strtotime($request->start_month . '-01'));
            $end_date = date('Y-m-t', strtotime($request->end_month . '-01'));
        }

        return $this->student_dao->fetchStudentsMonthlyReport($start_date, $end_date);        
    }
    
    public function getStudentsMonthlyTerminationReport($request)
    {
        $start_date = $end_date = NULL;

        if($request->start_month && $request->end_month){
            $start_date = date('Y-m-d', strtotime($request->start_month . '-01'));
            $end_date = date('Y-m-t', strtotime($request->end_month . '-01'));
        }

        return $this->report_dao->fetchStudentsMonthlyTerminationReport($start_date, $end_date);
    }

    public function getTrialClassSalesCallReport($request)
    {
        $filters['start_date'] = $filters['end_date'] = $filters['user_id'] = NULL;
        
        if ($request->start_date && $request->end_date) {
            $filters['start_date'] = $request->start_date;
            $filters['end_date'] = $request->end_date;
        }
        if ($request->user_id) {
            $filters['user_id'] = $request->user_id;
        }

        return $this->trial_class_call_histories_dao->fetchTrialClassSalesCallReport($filters);
    }

    public function getStudentsTrialClassPayableDetailsReport($request)
    {
        $filters['start_date'] = $filters['end_date'] = $filters['user_id'] = NULL;

        if ($request->start_date && $request->end_date) {
            $filters['start_date'] = $request->start_date;
            $filters['end_date'] = $request->end_date;
        }
        if ($request->user_id) {
            $filters['user_id'] = $request->user_id;
        }

        return $this->student_dao->fetchStudentsTrialClassPayableDetailsReport($filters);
    }

    public function getDueReport()
    {
        return $this->student_dao->fetchDueReport();
    }

    public function getUTMMediumReport($request)
    {
        $filters['start_date'] = $filters['end_date'] = NULL;

        if ($request->start_date && $request->end_date) {
            $filters['start_date'] = $request->start_date;
            $filters['end_date'] = $request->end_date;
        }

        return $this->trial_class_dao->fetchUTMMediumReport($filters);
    }

    public function getRecordingMappingMissingReport($request)
    {
        $filters['start_date'] = $filters['end_date'] = NULL;

        if ($request->start_date && $request->end_date) {
            $filters['start_date'] = $request->start_date;
            $filters['end_date'] = $request->end_date;
        }
        
        return $this->class_recording_dao->fetchRecordingMappingMissingReport($filters);
    }
}
