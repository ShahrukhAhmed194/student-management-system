<?php

namespace App\Http\Controllers;

use App\Services\WebServices\{StudentServices, ClassServices, StudentCallHistoryServices, StudentNoteHistoryServices, UserServices};
use App\Services\WebServices\{StudentAttendanceServices};
use App\Models\{DaClass, LeadLogInfo, NewLead, Student, StudentsParent, Payment};
use App\Models\{User, StudentCallHistory, StudentAttachmentHistory, StudentTrackLevel};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\students\UpdateStudentInfo;
use App\Services\FileUploadServices;
use App\Traits\Utils;
use Carbon\Carbon;


class StudentController extends Controller
{
    use UpdateStudentInfo, Utils;
    protected $fileUploadServices, $student_services, $class_services, $note_history_services;
    protected $student_attendance_services, $call_history_services, $user_services;
    public $user;

    public function __construct() {
        $this->fileUploadServices = new FileUploadServices();
        $this->student_services = new StudentServices();
        $this->class_services = new ClassServices();
        $this->note_history_services = new StudentNoteHistoryServices();
        $this->call_history_services = new StudentCallHistoryServices();
        $this->student_attendance_services = new StudentAttendanceServices();
        $this->user_services = new UserServices();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admitted_student.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any admitted student!');
        }
        $students = $id_list = $note_histories = array();
        $students = $this->student_services->getAdmittedStudentList($request);

        // if(!empty($students)){
        //     foreach($students as $key => $student){
        //         $id_list[$key] = $student->id;
        //     }
        //     $note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
        //         ->orderBy('created_at', 'DESC')
		//     ->get();
        // }
        $months = $this->getMonthsList();
        $status = 'Admitted';

        return view('students.index', compact('students', 'note_histories','status', 'months'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('students.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any student!');
        }

        return view('students.create', [
            'classes' => DaClass::where('status', 1)->get(),
            'parents' => StudentsParent::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = $request->user_type;
        $user->save();

        $student = new Student();
        $student->student_id = 'DA' . random_int(10000000, 99999999);
        $student->user_id = $user->id;
        $student->class_id = $request->class_id;
        $student->parent_id = $request->parent_id;
        $student->school = $request->school;
        $student->age = $request->age;
        $student->gender = $request->gender;
        $student->admitted_on = now();
        $student->admitted_by = auth()->user()->id;
        $student->save();

        NewLead::create([
            'student_id' => $student->student_id,
            'name' => $user->name,
            'mobile' => '0123456789',
            'email' => $user->email,
            'address' => 'address',
            'biography' => 'Test',
            'country' => 'BD',
            'city' => 'city',
            'state' => 'dhaka',
            'zipcode' => '1234',
            'enterprise_id' => '1',
            'status' => '1',
            'created_by' => '2',
            'updated_by' => '2',
        ]);
        // insert to loginfo table
        LeadLogInfo::create([
            'log_id' => $student->student_id,
            'name' => $user->name,
            'shortname' => 'shortname',
            'mobile' => '012345678',
            'email' => $user->email,
            'user_types' => '4',
            'is_admin' => '4',
            'ip_address' => '165.232.164.138',
            'status' => '1',
            'enterprise_id' => '1',
            'created_by' => '2',
            'updated_by' => '2'
        ]);

        toastr()->success('Student created successfully.');

        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('students.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any student!');
        }
        $tabs = $this->student_services->getTabsForStudentEditPage();
        $student = $this->student_services->getStudentByID($id);
        
        return view('students.edit', compact('student', 'tabs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!is_null($request->students_note)){
            $this->saveStudentNoteHistory($request, $id);
        }
        if($request->due_grace == 1){
            $request->merge([ 'students_note' => "Enabled Due Grace." ]);
            $this->saveStudentNoteHistory($request, $id);
        }
        $now = date('Y-m-d h:i:s', strtotime(now(). ' + 6 hours' ));

        $student = Student::find($id);
        $student->class_id = $request->class_id;
        $student->parent_id = $request->parent_id;
        $student->school = $request->school;
        $student->age = $request->age;
        $student->gender = $request->gender;
        if($request->action == 0){
            $student->terminated_on = $now;
            $student->terminated_by = auth()->user()->id;
        }elseif($request->action == 1){
            $student->admitted_on = $now;
            $student->admitted_by = $request->user_id;
        }elseif($request->action == 2){
            $student->graduated_on = $now;
            $student->graduated_by = auth()->user()->id;
        }elseif($request->action == 3){
            $student->on_hold_since = $now;
            $student->on_hold_by = auth()->user()->id;
        }elseif($request->action == 4){
            $student->deleted_on = $now;
            $student->deleted_by = auth()->user()->id;
        }else{
            $student->updated_at = $now;
            $student->updated_by = auth()->user()->id;
        }
        
        $student->status = $request->status;
        $student->class_start_date = $request->class_start_date;
        $student->active_payment = $request->active_payment == 'on' ? 1 : 0;
        $student->payable_amount = $request->payable_amount;
        $student->payment_status = $request->payment_status;
        $student->due_installments = $request->due_installments;
        $student->due_grace = $request->due_grace == 1 ? 1 : 0;
        $student->due_for_months = empty($request->due_for_months) ? '' : implode("," ,$request->due_for_months);
        $student->due_date = $request->due_date;
        if($request->status == 0){
            $student->terminated_on = Carbon::now();
        }
        $student->save();

        $user = User::find($student->user_id);
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->user_type = $request->user_type;
        $user->save();

        $query = Student::where('status', $request->status)
                        ->where('id', '!=', 0);
        if($request->payment_status == 'Pending'){

            $query->where('payment_status', 'Paid');
        }
        if($request->payment_status == 'Paid'){

            $query->where('payment_status', 'Pending');
        }
        $students = $query->get();
        $status = 1;

        toastr()->success('Student updated successfully.');

        return redirect('students')->with('students', 'status');
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function childs()
    {
        return view('parents.childs.index', [
            'childs' => Student::where('parent_id', auth()->user()->id)
                        ->where('status', 1)
                        ->get(),
        ]);
    }

    
    public function getStudentsOnHold(){
        $students_on_hold = Student::where('id', '!=', 0)
        ->where('payment_status', '!=', null)
        ->where('status', 3)
        ->count();

        return $students_on_hold;
    }

    public function showAllStudentsOnHold()
    {
        if (is_null($this->user) || !$this->user->can('on_hold_students.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any on hold student!');
        }
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 3 AND s.payment_status != 'null'");

        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        /*$note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
			->get();*/

	    $note_histories = array();

        $status = 'On Hold';

        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function showAllTerminatedStudents()
    {      
        if (is_null($this->user) || !$this->user->can('terminated_student.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any terminated student!');
        }
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 0 AND s.payment_status != 'null'");

        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        /*$note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
			->get();*/

	    $note_histories = array();

        $status = 'Terminated';

        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function showAllGraduatedStudents()
    {
        if (is_null($this->user) || !$this->user->can('graduated_student.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any graduated student!');
        }

        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 2 AND s.payment_status != 'null'");

        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        /*$note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
			->get();*/

	    $note_histories = array();

        $status = 'Graduated';

        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function showTotalStudents()
    {
        if (is_null($this->user) || !$this->user->can('students.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view student list!');
        }
        $students = DB::select("SELECT s.id, s.student_id, s.status, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.payment_status != 'null' AND s.status != 4");

        foreach($students as $key => $student){
            $id_list[$key] = $student->id;
        }
        /*$note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
			->get();*/

	    $note_histories = array();

        $status = 'Total';

        return view('students.index', compact('students', 'note_histories','status'));
    }

    public function showStudentsPerClass($id)
    {
        if (is_null($this->user) || !$this->user->can('classes.students')) {
            abort(403, 'Sorry !! You are Unauthorized to view class students !');
        }
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name, u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status, s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		JOIN users us ON (us.id = s.user_id)
		JOIN parents p ON (p.user_id = s.parent_id)
		JOIN users u ON (u.id = p.user_id)
        JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 1 AND s.class_id = $id");

        if($students){ 
            foreach($students as $key => $student){
                $id_list[$key] = $student->id;
            }
            $status = $students[0]->class_name;
        }else{
            $id_list = [];
            $status = NULL;
        }
        /*$note_histories = StudentNoteHistories::whereIn('student_id', $id_list)
                        ->orderBy('created_at', 'DESC')
	 		->get();
	    */

	    $note_histories = array();

        return view('students.index', compact('students', 'note_histories','status'));
    }


    public function allstudents(){
        if (is_null($this->user) || !$this->user->can('students.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any students !');
        }

        $students = User::where('user_type', User::USER_TYPE_STUDENT)
        ->orderBy('name','asc')
        ->get();
        
        return view('students.allstudents', compact('students'));
    }

    public function studentEdit($id){
        if (is_null($this->user) || !$this->user->can('students.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any student!');
        }

        $allresults = array(
            'student' => User::find($id),
        );

        return view('students.allStudentedit', compact('allresults'));
    }

    public function allstudents_update(Request $request, $id){
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        toastr()->success('Student updated successfully.');

        return redirect('allstudents');
    }
    
    public function saveStudentCallHistory(Request $request){
        $user_id = $request->user_id;
        $student_id = $request->student_id;
        $phone = $request->phone;
        
        StudentCallHistory::create([
            'student_id' => $student_id,
            'user_id' => $user_id,
            'phone' => $phone,
        ]);

        return true;
    }

    public function fetchAttachment($id){         
        $attachmentHistories = StudentAttachmentHistory::where('student_id', $id)->orderBy('id', 'desc')->get();
        $studentId = $id;
        return view('students.tabs.attachment', compact('attachmentHistories', 'studentId'));
    }

    public function attachmentSave(Request $request){
        $user_id = $request->user_id;
        $student_id = $request->student_id;
        $notes = $request->notes;

        $attachment = $this->fileUploadServices->imageUpload($request, 'attachment', 'assets/uploads/attachments','','');
        
        StudentAttachmentHistory::create([
            'student_id' => $student_id,
            'user_id' => $user_id,
            'notes' => $notes,
            'attachment' => $attachment,
        ]);

        toastr()->success('Attachment uploaded successfully.');
        return redirect()->back();
    }

    public function attachmentShow(Request $request){
        $id = $request->id;
        $getAttachmentInfo = StudentAttachmentHistory::findOrFail($id);

        return view('students.attachmentShow', compact('getAttachmentInfo'));
    }

    public function studentAttachmentDelete($id){
        $checkrecord = StudentAttachmentHistory::findOrFail($id);

        if ($checkrecord) {
            $permission = StudentAttachmentHistory::where("id", "=", $id);
            $permission->delete();
            unlink(public_path($checkrecord->attachment));

            $response = array(
                'success' => true,
                'title' => 'Student Attachment',
                'message' => 'Deleted Successfully'
            );
            return json_encode($response);
        }
    }
    
    public function studentTrackLevelSave(Request $request){
        $start_date = $request->start_date;
        $completion_date = $request->completion_date;
        
        $student_id = $request->student_id;
        $track_id = $request->track_id;
        $level_id = $request->level_id;

        $getStudentTrackLevelInfo = StudentTrackLevel::where('student_id', $student_id)
                                    ->where('track_id', $track_id)
                                    ->where('level_id', $level_id)
                                    ->first();
        
        if($getStudentTrackLevelInfo){
            StudentTrackLevel::where('id', $getStudentTrackLevelInfo->id)->update([
                'start_date' => (!empty($start_date) ? $start_date : $getStudentTrackLevelInfo->start_date),
                'completion_date' => (!empty($completion_date) ? $completion_date : $getStudentTrackLevelInfo->completion_date),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return 'Updated successfully.';
        }else{
            StudentTrackLevel::create([
                'student_id' => $student_id,
                'track_id' => $track_id,
                'level_id' => $level_id,
                'start_date' => $start_date,
                'completion_date' => $completion_date,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return 'Added successfully.';
        }
    
    }

    public function getStudentUsingId($id)
    {
         $student =  $this->student_services->getStudentByID($id);
         $months = $this->getMonthsList();
         $classes = $this->class_services->getAllClassList();
         $users = $this->user_services->getAllUsersButParentStudentAndTeacher();

         return view('students.tabs.edit-form', compact('student', 'months', 'classes', 'users'));
    }

    public function getNotesOfStudent($id)
    {
        $note_histories = $this->note_history_services->getNoteHistoryOfStudent($id);

        return view('students.tabs.student-notes', compact('note_histories'));
    }

    public function getCallHistoryOfStudent($id)
    {
        $call_histories =  $this->call_history_services->getStudentCallHistoryList($id);

        return view('students.tabs.call-history', compact('call_histories'));
    }
}
