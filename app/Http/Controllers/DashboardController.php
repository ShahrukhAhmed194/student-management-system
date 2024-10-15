<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\ClassSession;
use App\Models\DaClass;
use App\Models\Student;
use App\Models\StudentProject;
use App\Models\StudentQuiz;
use App\Models\TrialClass;
use App\Models\NoteUpdateHistory;
use App\Models\StudentNoteHistories;
use App\Models\TrialClassSchedule;
use App\Models\StudentRewardPoint;
use App\Models\SalesUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\WebServices\{TrialClassServices, SalesUserServices, TrialClassNoteUpdateHistoryServices, UserServices};

class DashboardController extends Controller
{
    public $user;
    protected $trial_Class_services, $sales_user_services, $trial_Class_note_serevices, $user_services;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });

        $this->user_services = new UserServices();
        $this->trial_Class_services = new TrialClassServices();
        $this->sales_user_services = new SalesUserServices();
        $this->trial_Class_note_serevices = new TrialClassNoteUpdateHistoryServices();
    }

    public function index()
    {
        if ((auth()->user()->user_type === User::USER_TYPE_SUPER_ADMIN) || (auth()->user()->user_type === User::USER_TYPE_ADMIN) || (auth()->user()->user_type === User::USER_TYPE_COORDINATOR) || (auth()->user()->user_type === User::USER_TYPE_SALES_EXECUTIVE) || (auth()->user()->user_type === User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE)) {
            return view('dashboards.admin');
        } elseif (auth()->user()->user_type === User::USER_TYPE_PARENT) {
            $payments = DB::table('parents')
                        ->join('students', 'parents.user_id', 'students.parent_id')
                        ->join('users', 'users.id', 'students.user_id')
                        ->join('payments', 'payments.student_id', 'students.id')
                        ->where('students.parent_id', auth()->user()->id)
                        ->where('payments.is_delete', false)
                        ->orderBy('payments.created_at', 'DESC')
                        ->limit(5)->get();
            // $students = Student::where('parent_id', auth()->user()->id)->get();
            $students = Student::select('*', 'students.id as studentId')
                                ->join('class_schedules', 'class_schedules.class_id', '=', 'students.class_id')
                                ->where('parent_id', auth()->user()->id)
                                ->get();

            return view('dashboards.parent', compact('payments', 'students'));
        } elseif (auth()->user()->user_type === User::USER_TYPE_TEACHER) {
            
            $dayOfToday = Carbon::now()->addHours(6)->format('l');
            $dateOfToday = Carbon::now()->addHours(6)->format('Y-m-d');
            $schedules[0] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Saturday')->get();
            $schedules[1] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Sunday')->get();
            $schedules[2] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Monday')->get();
            $schedules[3] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Tuesday')->get();
            $schedules[4] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Wednesday')->get();
            $schedules[5] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Thrusday')->get();
            $schedules[6] = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')->where('da_classes.status', 1)->where('class_schedules.teacher_id', auth()->user()->id)->where('class_schedules.day', 'Friday')->get();
            
            $todays_schedules = ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')
            ->where('da_classes.status', 1)
            ->where('class_schedules.teacher_id', auth()->user()->id)
            ->where('class_schedules.day', $dayOfToday)->get();

            $trial_classes = TrialClassSchedule::where('teacher_id', auth()->user()->id)
            ->where('status', 1)
            ->where('date', date('Y-m-d', strtotime(Date(now()))))
            ->get();

            $todays_sessions = ClassSession::where('teacher_id', auth()->user()->id)
            ->where('session_date', $dateOfToday)
            ->get();

            $status = array();
            foreach($todays_schedules as $key => $schedule){
                foreach($todays_sessions as $session){
                    if($session->class_id == $schedule->class_id){
                        $status[$key] = $session->status;
                    }
                }
            }

            return view('dashboards.teacher', 
            compact('schedules','trial_classes','todays_schedules', 'dateOfToday', 'status'));
        } else {
            $dateOfToday = Carbon::now()->addHours(6)->format('Y-m-d');
            $student = Student::where('user_id', auth()->user()->id)->first();
            $todays_session = ClassSession::where('class_id', $student->class_id)
                            ->where('session_date', $dateOfToday)->first();
                            
            $totalPoint = StudentRewardPoint::where('student_id', auth()->user()->id)->sum('points');
            $todays_session_status = empty($todays_session) ? '' : $todays_session->status;
            
            
            return view('dashboards.student', [
                'class' => DaClass::find($student->class_id),
                'class_schedules' => ClassSchedule::where('class_id', $student->class?->id)
                    ->get(),
                'student' => $student,
                'projects' => StudentProject::where('student_id', auth()->user()->id)
                    ->where('project_status', '!=', 'COMPLETE')
                    ->get(),
                'quizs' => StudentQuiz::where('student_id', auth()->user()->id)
                    ->where('quiz_status', '!=', 'COMPLETE')
                    ->get(),
                'todays_session_status' => $todays_session_status,
                'totalPoint' => $totalPoint,
                'todays_session' => $todays_session,
            ]);
        }
    }

    public function getTotalMyworklist()
    {
        $total_registrations = TrialClass::orderBy('created_at', 'DESC')
        ->where('status', '!=', 'Invalid')
        ->where('status', '!=', '')
        ->where('trial_class_id', '!=', '0')
        ->where('sales_user_id', Auth::user()->id)
        ->count();

        return $total_registrations;
    }
    public function getTotalRegistrations()
    {
        $total_registrations = TrialClass::orderBy('created_at', 'DESC')
        ->where('status', '!=', 'Invalid')
        ->where('status', '!=', '')
        ->where('trial_class_id', '!=', '0')
        ->count();

        return $total_registrations;
    }

    public function getActiveStudents()
    {
         $active_students = Student::where('id', '!=', 0)
         ->where('payment_status', '!=', null)
         ->where('status', 1)
         ->count();

         return $active_students;
    }

    public function getTerminatedStudents()
    {
        $terminated_students = Student::where('id', '!=', 0)
        ->where('payment_status', '!=', null)
        ->where('status', 0)
        ->count(); 

        return $terminated_students;
    }

    public function getGraduatedStudents()
    {
        $graduated_students = Student::where('id', '!=', 0)
        ->where('payment_status', '!=', null)
        ->where('status', 2)
        ->count();

        return $graduated_students;
    }

    public function getTotalStudents()
    {
        return Student::where('id', '!=', 0)->paymentNotNull()->notDeleted()->count();
    }

    public function getTrialClassStudentsYesterday()
    {

         $yesterday = Carbon::now()->subDay()->format('Y-m-d');

         $query = TrialClass::
         join('trial_class_schedules','trial_classes.trial_class_id', '=', 'trial_class_schedules.id')
         ->where('trial_classes.status', '!=', 'Invalid')
         ->where('trial_classes.status', '!=', '')
         ->where('trial_classes.trial_class_id', '!=', 0);
         if(auth()->user()->email ==  'admin@dreamersacademy.co.uk' ){
             $query = $query->where('trial_classes.country', 'United Kingdom');
         }
        $query = $query->where('trial_class_schedules.date', $yesterday)
               ->groupBy('trial_classes.email')
               ->distinct()
               ->get();
        $trial_class_students_yesterday = $query->count();
        
        return $trial_class_students_yesterday;
    }

    public function getTrialClassStudentsToday()
    {
        $dateOfToday = Carbon::now()->format('Y-m-d');

        $query = TrialClass::
        join('trial_class_schedules','trial_classes.trial_class_id', '=', 'trial_class_schedules.id')
        ->where('trial_classes.status', '!=', 'Invalid')
        ->where('trial_classes.status', '!=', '')
        ->where('trial_classes.trial_class_id', '!=', 0);
        if(auth()->user()->email ==  'admin@dreamersacademy.co.uk' ){
            $query = $query->where('trial_class_schedules.country', 'United Kingdom');
        }
        $query = $query->where('trial_class_schedules.date', $dateOfToday)
        ->groupBy('trial_classes.email')->distinct()->get();
        $trial_class_students_today = $query->count();
        
        return $trial_class_students_today;
    }

    public function getTrialClassStudentsTomorrow()
    {
         $tomorrow = Carbon::now()->addDay()->format('Y-m-d');

         $query = TrialClass::
         join('trial_class_schedules','trial_classes.trial_class_id', '=', 'trial_class_schedules.id')
         ->where('trial_classes.status', '!=', 'Invalid')
         ->where('trial_classes.status', '!=', '')
         ->where('trial_classes.trial_class_id', '!=', 0);
         if(auth()->user()->email ==  'admin@dreamersacademy.co.uk' ){
             $query = $query->where('trial_class_schedules.country', 'United Kingdom');
         }
        $query = $query->where('trial_class_schedules.date', $tomorrow)
        ->groupBy('trial_classes.email')->distinct()->get();
        $trial_class_students_tomorrow = $query->count();
        
        return $trial_class_students_tomorrow;
    }

    public function getPaymentReceivedStudents()
    {
        $total_payment_paid_students = Student::where('payment_status', 'Paid')
        ->where('id', '!=', 0)
        ->where('status', 1)
        ->count();

        return $total_payment_paid_students;
    }

    public function getDuePaymentStudents()
    {
        $total_payment_pending_students = Student::where('payment_status', 'Pending')
        ->where('id', '!=', 0)
        ->where('status', 1)
        ->count();

        return $total_payment_pending_students;
    }

    public function showTrialClassStudentsYesterday()
    {
        if (!auth()->user()->can('trial_class_student_yesterday.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view trial class yesterday student list!');
        }
        $request = request();
        $request->merge([
            'sales_user_id' => Auth::user()->id,
            'day' => Carbon::now()->subDay()->format('Y-m-d')
        ]);
        $customerSupportExecutives = $this->user_services->getAllCustomerSupportExecutives();
        $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
        $parametersData = $this->trial_Class_services->getParameterDatas($request ,'day');
        $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
        $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
        $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);


        return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'customerSupportExecutives'));
    }

    public function showTrialClassStudentsToday()
    {
        if (!auth()->user()->can('trial_class_student_today.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view trial class today student list!');
        }
        
        $request = request();
        $request->merge([
            'sales_user_id' => Auth::user()->id,
            'day' => Carbon::now()->format('Y-m-d')
        ]);
        $customerSupportExecutives = $this->user_services->getAllCustomerSupportExecutives();
        $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
        $parametersData = $this->trial_Class_services->getParameterDatas($request ,'day');
        $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
        $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
        $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);


        return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'customerSupportExecutives'));    
    }

    public function showTrialClassStudentsTomorrow()
    {
        if (!auth()->user()->can('trial_class_student_tomorrow.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view trial class tomorrow student list!');
        }
        $request = request();
        $request->merge([
            'sales_user_id' => Auth::user()->id,
            'day' => Carbon::now()->addDay()->format('Y-m-d')
        ]);
        $customerSupportExecutives = $this->user_services->getAllCustomerSupportExecutives();
        $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
        $parametersData = $this->trial_Class_services->getParameterDatas($request ,'day');
        $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
        $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
        $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);


        return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'customerSupportExecutives'));
    }

    public function showPaymentReceivedStudents()
    {
        if (!auth()->user()->can('student_received_payment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view student received payment!');
        }
        
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		JOIN users us ON (us.id = s.user_id)
		JOIN parents p ON (p.user_id = s.parent_id)
		JOIN users u ON (u.id = p.user_id)
        JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 1 AND s.payment_status = 'Paid'");
        
        $id_list = array();
        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        $note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
                        ->get();
        $status = 'Payment Received';

        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function showDuePaymentStudents()
    {
        if (!auth()->user()->can('student_due_payment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view student due payment!');
        }
        
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 1 AND s.payment_status = 'Pending'");
        
        $id_list = array();
        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        $note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
                        ->get();
        $status = 'Due Payment';
        
        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function getStudentsCountByTeacher()
    {
        $student_count_by_teacher_table = DB::select("SELECT users.name AS 'Teacher' ,
        COUNT(CASE WHEN students.status=1 THEN 1 END) AS 'Active' , 
        COUNT(CASE WHEN students.status=0 THEN 1 END) AS 'Terminated' 
        FROM `students` 
        INNER JOIN da_classes ON students.class_id = da_classes.id 
        INNER JOIN users ON da_classes.teacher_id = users.id
        WHERE users.status = 1
        GROUP BY users.name");

        return $student_count_by_teacher_table;
    }

    public function getStudentsCountByCountry()
    {
        $student_count_by_country_table = DB::select("SELECT DISTINCT trial_classes.country, COUNT(country) AS registrations
        FROM trial_classes
        WHERE  status != 'Invalid' and id != 0 and status != ''
        GROUP BY country
        ORDER BY COUNT(country) DESC
        LIMIT 5");

        return $student_count_by_country_table;
    }

    public function getStudentsCountByAge()
    {
        $student_count_by_age_chart = DB::select("SELECT
        COUNT(CASE WHEN age=7 THEN 1 END) AS 'age_7' , 
        COUNT(CASE WHEN age=8 THEN 1 END) AS 'age_8' , 
        COUNT(CASE WHEN age=9 THEN 1 END) AS 'age_9' , 
        COUNT(CASE WHEN age=10 THEN 1 END) AS 'age_10' , 
        COUNT(CASE WHEN age=11 THEN 1 END) AS 'age_11' , 
        COUNT(CASE WHEN age=12 THEN 1 END) AS 'age_12' , 
        COUNT(CASE WHEN age=13 THEN 1 END) AS 'age_13' , 
        COUNT(CASE WHEN age=14 THEN 1 END) AS 'age_14' , 
        COUNT(CASE WHEN age=15 THEN 1 END) AS 'age_15' , 
        COUNT(CASE WHEN age=16 THEN 1 END) AS 'age_16' 
        FROM `trial_classes`
        WHERE  status != 'Invalid' and id != 0 and status != ''");

        return $student_count_by_age_chart;
    }

    public function getStudentsCountByGender()
    {
        $student_count_by_gender_chart = DB::select("SELECT
        COUNT(CASE WHEN gender='Male' THEN 1 END) AS 'male' , 
        COUNT(CASE WHEN gender='Female' THEN 1 END) AS 'female'
        FROM `trial_classes`
        WHERE  status != 'Invalid' and id != 0 and status != ''");
        
        return $student_count_by_gender_chart;
    }
    
    // get students not assigned count
    public function getStudentsNotAssignedCount()
    {
        return Student::where('class_id', 1)->paymentNotNull()->admitted()->count();
    }
    
    // get advanced payment count
    public function getAdvancedPaymentCount()
    {
        return Student::paymentPaid()->admitted()->where('due_installments', '<=', 0)
            ->where(function ($query) {
                $query->where('due_for_months', '!=', '')
                    ->where('due_for_months', '!=', null);
            })
        ->count();
    }
    
    // get non advanced payment count
    public function getNonAdvancedPaymentCount()
    {
        return Student::paymentPaid()->admitted()->where('due_installments', 1)
            ->where(function ($query) {
                $query->where('due_for_months', '!=', '')
                    ->where('due_for_months', '!=', null);
            })
            ->count();
    }
    
    // get wrong payment count
    public function getWrongPaymentCount()
    {
        return Student::paymentPaid()->admitted()
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('due_for_months', '')
                        ->orWhere('due_for_months', null);
                })
                ->orWhere(function ($query) {
                    $query->where('due_installments', '>', 1)
                        ->orWhere('due_installments', null);
                });
            })
        ->count();
    }
    
    // get month due count
    public function getMonthDueCount($month)
    {
        $sign = decrypt($month) == 3 ? '>=' : '=';
        
        return Student::paymentPending()->admitted()->where('due_installments', $sign, decrypt($month))->count();
    }
    
    // get wrong due count
    public function getWrongDueCount()
    {
        return Student::paymentPending()->admitted()->where(function ($query) {
            $query->where('due_installments', 0)
                ->orWhere('due_installments', '<', 0)
                ->orWhere('due_installments', null);
        })->count();
    }
    
}
