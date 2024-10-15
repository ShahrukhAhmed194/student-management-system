<?php

namespace App\Http\Controllers;

use App\Traits\attendance\AttendanceStudentList;
use App\Traits\NotifyParent;
use App\Traits\SendMessage;
use App\Traits\WhatsAppNotification;
use App\Models\DaClass;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\ClassSession;
use App\Models\StudentsParent;
use App\Models\StudentRewardPoint;
use App\Models\RewardPointsStructure;
use App\Models\User;
use App\Services\WebServices\{StudentAttendanceServices};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{
    use AttendanceStudentList, NotifyParent, SendMessage, WhatsAppNotification;

    protected $student_attendance_services;
    
    public function __construct()
    {
        $this->student_attendance_services = new StudentAttendanceServices();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('web')->user()->can('attendance.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view attendance list !');
        }
        
        return view('attendance.index', [
            'attendances' => StudentAttendance::orderBy('date', 'DESC')
                ->where('teacher_id', auth()->user()->id)
                ->limit(100)
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!auth('web')->user()->can('attendance.add')) {
            abort(403, 'Sorry !! You are Unauthorized to create attendance !');
        }
        $from = $request->from == 'session' ? $request->from : '';
        $classes = DaClass::where('teacher_id', auth()->user()->id)
                ->where('status', 1)
                ->get();
        
        if ($request->class_id && $request->date) {

            $lists = $this->getStudentsForAttendance($request);
        }else{
            
            $lists = $this->getEmptyListsForAttendance();
        }

        return view('attendance.create', compact('lists', 'classes', 'from'));
    }

    /*
    this function inactivates the class
    */

    public function inactiveClass($id){
        $class= DaClass::find($id);
        if(empty($class)){
            return view('pages.error-404');
        }
        else{
            $class->status = 0;
            $class->save();

            toastr()->success('Class Has Been Deactivated.');
            return redirect('class');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = StudentAttendance::where('date' ,$request->date)->count();
        $new_session = ClassSession::where('class_id', $request->class_id)
                    ->where('session_date', $request->date)->get();
        $from = NULL;
        $id = $request->class_id;
        foreach ($request->attendances as $attendance) {
            $student_id = $attendance['student_id'];
            $studnetInfo = Student::with('parentInfo')->with('parent')->with('user')
                        ->where('id', $student_id)->first();
            $presentAbsent = $attendance['status'];
            $sms_msg = $whatapp_msg = $email_msg = '';

            // ----------------- its for student reward point -------------
            $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
            $points = $existsRewardPoint = 0;
            if($existsRewardInfo){
                $existsRewardPoint = $existsRewardInfo->points;   
            }
            if($presentAbsent == 1){
              $presentPoint = RewardPointsStructure::where('type', 'ATTENDANCE_PRESENT')->first();
                $points = ($existsRewardPoint+$presentPoint->points);
            }elseif($presentAbsent == 0){
              $absentPoint = RewardPointsStructure::where('type', 'ATTENDANCE_ABSENT')->first();
                $points = ($existsRewardPoint+$absentPoint->points);
            }

            if($existsRewardInfo){
                $rewardData = StudentRewardPoint::where("student_id", $student_id)->update([
                    "points" => $points,
                ]); 
            }else{
                $rewardData = StudentRewardPoint::create([
                    "student_id" => $student_id,
                    "points" => $points,
                ]);
            }
            // ----------------- its for student reward point -------------

            if($presentAbsent == 0){ 
                $parentEmail = (!empty($studnetInfo) ? $studnetInfo->parent->email : '');
                //$parentPhone = (!empty($studnetInfo) ? $studnetInfo->parentInfo->phone : '');
                $parentName = (!empty($studnetInfo) ? $studnetInfo->parent->name : '');
                $studentName = (!empty($studnetInfo) ? $studnetInfo->user->name : '');
                
                $whatapp_msg = "আপনার সন্তান : (".$studentName.") আজকের কোডিং  ক্লাসে অনুপস্থিত ছিল। কোডিং ক্লাস করতে যদি কোনো সমস্যা হয়ে থাকে আমাদের জানাবেন। আমরা সর্বাত্মক চেষ্টা করবো সমাধান দেওয়ার।
Dreamers Academy";
                $email_msg = "Your child: (".$studentName.") was absent in today's Coding class. Please contact us as soon as possible.
                Phone Numbers: +8801897-717780, +8801897-717781";

                
                /**
                 *  send whatsapp message to parent to notify about trial class registration.
                 *  paremeter: recevier number, messeage
                 */
                if(config('app.env') === 'production'){
                    //$this->sendWANotificationSecond($parentPhone, $whatapp_msg);
                }

                 /* 
                 *Send email to instructor for trial class notification
                 *parameters : receiver mail, date, time, zoom link.
                 */
                 $contentData = [
                            'subject' => 'Coding Class Attendance Alert',
                            'parentName' => $parentName,
                            'email_msg' => $email_msg,
                        ];
                //\Mail::to($parentEmail)->send(new \App\Mail\NotifyPresentAbsentMailer($contentData));

            }

            StudentAttendance::updateOrInsert(
                ['class_id' => $request->class_id, 'student_id' => $attendance['student_id'], 'date' => $request->date ],
                ['teacher_id' => $request->teacher_id, 'status' => $attendance['status'], 'comments' => $attendance['comment']]
            );
        }

        toastr()->success('Class attendence created successfully.');
        if($request->from == 'session'){
            return redirect()->route('session-teacher', compact('id', 'new_session', 'from'));
        }else{
            return redirect()->route('attendance.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth('web')->user()->can('attendance.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit attendance !');
        }
        
        $studentAttendance = StudentAttendance::find($id);

        return view('attendance.edit', [
            'classes' => DaClass::where('teacher_id', auth()->user()->id)
                            ->where('status', 1)->get(),
            'attendance' => $studentAttendance,
            'students' => Student::where('class_id', $studentAttendance->class_id)
                          ->where('status', 1)->get(),
            'selected' => [
                'class_id' => $studentAttendance->class_id,
                'teacher_id' => DaClass::find($studentAttendance->class_id)->teacher_id,
                'date'  => $studentAttendance->date,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attn = StudentAttendance::find($id);
        $attn->student_id = $request->student_id;
        $attn->status = $request->status;
        $attn->comments = $request->comment;
        $attn->save();

        toastr()->success('Class attendence updated successfully.');
        return redirect()->route('attendance.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }

    
    /**
     * Show students name in parent report page dropdown
     * 
     * @param
     * @return students
     */

    public function showStudents(){
        
        if (!auth('web')->user()->can('attendance_report.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view attendance report !');
        }

        if(auth()->user()->user_type === User::USER_TYPE_ADMIN || auth()->user()->user_type === User::USER_TYPE_SUPER_ADMIN){
           $students = Student::select('students.user_id', 'students.status', 'users.name')
                        ->join('users', 'users.id', 'students.user_id')
                        ->orderBy('users.name', 'ASC')
			->get();

            $classes = DaClass::where('status', 1)
                        ->orderBy('name', 'ASC')
                        ->get();

            return view('admin.attendance', compact('students', 'classes'));
        }else{
            $students = Student::where('parent_id', auth()->user()->id)->get();

            return view('parents.attendance', compact('students'));
        }
        
     }

     /** 
      * Get students attendance information
      *
      *@param 
      *@return Attendance
      */
    public function getAttendanceInfo(Request $request){

        $query = StudentAttendance::select('users.id', 'users.name', 'student_attendances.date', 
                'student_attendances.status', 'student_attendances.comments')
                ->join('students', 'students.user_id', 'student_attendances.student_id')
                ->join('users', 'users.id', 'students.user_id');
        if(!is_null($request->class_id)){
            $query->where('student_attendances.class_id', $request->class_id);
        }
        if(!is_null($request->id)){
            $query = $query->where('student_attendances.student_id', $request->id);
        }
        if($request->from_date && $request->to_date){
            $query = $query->whereBetween('student_attendances.date', [$request->from_date, $request->to_date]);
        }
        $attendances = $query->get();
        
        return $attendances;
    }

    
    public function getChildsAttendanceHistory($id)
    {
        $attendances = StudentAttendance::with('student')
                     ->where('student_id', $id)
                     ->orderBy('date', 'DESC')
                     ->get();
        return $attendances;
    }

    public function getStudentsAttendanceHistory($id)
    {
        $attendances = $this->student_attendance_services->getStudentAttendanceHistory($id);
        
        return view('students.tabs.attendance', compact('attendances'));
    }
    
}
