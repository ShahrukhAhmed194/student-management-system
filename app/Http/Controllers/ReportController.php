<?php

namespace App\Http\Controllers;

use App\Traits\validators\ReportsValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\DAO\WebDao\DaoForReports;
use App\Services\WebServices\ReportServices;
use App\Services\WebServices\UserServices;

class ReportController extends Controller
{
    use ReportsValidator;
    // globally accessable public variables
    public $user;
    //DAO objects
    protected $dao_for_reports, $report_services, $user_services;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
        $this->user_services = new UserServices();
        $this->dao_for_reports = new DaoForReports();
        $this->report_services = new ReportServices();
    }

    public function index(){
        if (is_null($this->user) || !$this->user->can('comprehensive_report.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view comprehensive report !');
        }
    
        $collection = array();
        $total_count = array();
        return view('report.index', compact('collection', 'total_count'));
    }

    public function getReportStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date|before_or_equal:to_date|after_or_equal:2021-01-01',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        if ($validator->fails()) {
            return redirect('report-show-comprehensively')
                        ->withErrors($validator)
                        ->withInput();
        }
        $start_date = $request->from_date;
        $end_date   = $request->to_date;
        $query_params = ['start_date' => $start_date, 'end_date' => $end_date];
        Session::put('searched_data',['start_date' => $start_date, 'end_date' => $end_date]);

        $collection = DB::select("SELECT trialSchedule.date AS Date,
                        COUNT(DISTINCT trialClass.email) AS 'Registered' ,
                        COUNT(CASE WHEN trialClass.status='Attended' THEN 1 END) AS 'Attended' ,
                        COUNT(CASE WHEN trialClass.status='Will Attend' THEN 1 END) AS 'WillAttend' ,
                        COUNT(CASE WHEN trialClass.status='Absent' THEN 1 END) AS 'Absent' ,
                        COUNT(CASE WHEN trialClass.status='Refused Admission' THEN 1 END) AS 'RefusedAdmission' ,
                        COUNT(CASE WHEN trialClass.status='Will Admit Later' THEN 1 END) AS 'WillAdmitLater' ,
                        COUNT(CASE WHEN trialClass.status='Admitted' or trialClass.status='Payment Pending' THEN 1 END) AS 'Admitted',
                        COUNT(CASE WHEN trialClass.status='Rescheduled' THEN 1 END) AS 'Rescheduled'
                        FROM trial_classes trialClass
                        JOIN trial_class_schedules trialSchedule ON (trialSchedule.id = trialClass.trial_class_id)
                        WHERE trialClass.status != ''
                        AND trialClass.status != 'Invalid'
                        AND trialClass.trial_class_id != 0
                        AND trialSchedule.date >= :start_date
                        AND trialSchedule.date <= :end_date
                        GROUP BY trialSchedule.date
                        ORDER BY trialSchedule.date ASC
                        ", $query_params);
            
        $total_count = DB::select("SELECT 
                        COUNT(DISTINCT trialClass.email) AS 'Registered' ,
                        COUNT(CASE WHEN trialClass.status='Attended' THEN 1 END) AS 'Attended' ,
                        COUNT(CASE WHEN trialClass.status='Absent' THEN 1 END) AS 'Absent' ,
                        COUNT(CASE WHEN trialClass.status='Admitted' or trialClass.status='Payment Pending' THEN 1 END) AS 'Admitted' 
                        FROM trial_classes trialClass
                        JOIN trial_class_schedules trialSchedule ON (trialSchedule.id = trialClass.trial_class_id)
                        where trialClass.id != 0
                        AND trialClass.status != 'Invalid'
                        AND trialSchedule.date >= :start_date
                        AND trialSchedule.date <= :end_date
                        ", $query_params);
  
        return view('report.index',compact('collection', 'total_count'));
    }

    public function showRegistrationReports()
    {
        if (is_null($this->user) || !$this->user->can('attendance_report.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view registrations report !');
        }
        return view('report.registrations');
    }

    public function showSalesReport(Request $request){
        if (is_null($this->user) || !$this->user->can('report.sales')) {
            abort(403, 'Sorry !! You are not authorized to see any sales report!');
        }
        
        $reports = array();
        $reportsTotalSalesSum = array();
        if(is_null($request->start_date) && is_null($request->end_date)){
            $reports = $this->dao_for_reports->fetchSalesCountForCSTeam(date('Y-m-d'), date('Y-m-d'));
            $reportsTotalSalesSum = $this->dao_for_reports->fetchSalesSumForCSTeam(date('Y-m-d'), date('Y-m-d'));
        }else{
            $validator = $this->validateSearchParamsOfSalesReport($request);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $reports = $this->dao_for_reports->fetchSalesCountForCSTeam($request->start_date, $request->end_date);
            $reportsTotalSalesSum = $this->dao_for_reports->fetchSalesSumForCSTeam($request->start_date, $request->end_date);
        }
        
        return view('report.sales', compact('reports', 'reportsTotalSalesSum'));
    }

    public function showInstructorStudentCountReport(Request $request)
    {
        
        $search_params['teacher_id'] = $request->teacher_id ?? Null;
        $students = $this->report_services->getStudentCountByInstructor($search_params);
        $teachers = $this->user_services->getAllTeacher();

        return view('report.teacher', compact('search_params', 'students', 'teachers'));
    }

    public function showTrialClassAdmissionReport(Request $request)
    {
        $search_params = $this->report_services->getParamsForTrialClassReport($request);
        $parents = $this->report_services->getParentDetailsOfEachTrialClassRegistration($search_params);

        return view('report.trial-class', compact('search_params', 'parents'));
    }

    public function showStudentsMonthlyReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.students')) {
            abort(403, 'Sorry !! You are Unauthorized to view Students Monthly Report !');
        }
        
        $students = $this->report_services->getStudentsMonthlyReport($request);

        return view('report.students', compact('students'));
    }
    
    public function showStudentsMonthlyTerminationReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.termination')) {
            abort(403, 'Sorry !! You are Unauthorized to view Student Termination report !');
        }
        
        $students = $this->report_services->getStudentsMonthlyTerminationReport($request);

        return view('report.termination', compact('students'));
    }

    public function showTrialClassSalesCallReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.sales_call')) {
            abort(403, 'Sorry !! You are Unauthorized to view Trial Class Sales Call report !');
        }

        $sales_reports = $this->report_services->getTrialClassSalesCallReport($request);
        $users = $this->user_services->getAllUsersButParentStudentAndTeacher();

        return view('report.sales-call', compact('sales_reports', 'users'));
    }

    public function showTrialClassPayableDetailsReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.trial_class_payable')) {
            abort(403, 'Sorry !! You are Unauthorized to view Trial Class Payable Details report !');
        }

        $students = $this->report_services->getStudentsTrialClassPayableDetailsReport($request);
        $users = $this->user_services->getAllUsersButParentStudentAndTeacher();

        return view('report.trial-class-payable', compact('students', 'users'));
    }

    public function showDueReport()
    {
        if (is_null($this->user) || !$this->user->can('report.due')) {
            abort(403, 'Sorry !! You Are Unauthorized To View Due Report !');
        }

        $students = $this->report_services->getDueReport();

        return view('report.due', compact('students'));
    }

    public function showUTMMediumReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.utm_medium')) {
            abort(403, 'Sorry !! You are Unauthorized to view Trial Class UTM report !');
        }

        $students = $this->report_services->getUTMMediumReport($request);

        return view('report.utm-medium', compact('students'));
    }

    public function showRecordingMappingMissingReport(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('report.missing_recording')) {
            abort(403, 'Sorry !! You Are Unauthorized To View Messing Recording Mapping Report !');
        }

        $missing_recordings = $this->report_services->getRecordingMappingMissingReport($request);

        return view('report.recording-mapping', compact('missing_recordings'));
    }
}