<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseTrack;
use App\Models\DaClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaClassController extends Controller
{

    public $user;

    public function __construct() {
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
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('classes.list')) {
           abort(403, 'Sorry !! You are Unauthorized to list view any class !');
       }
       
        return view('class.index', [
            'classes' => DaClass::where('status', 1)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('classes.add')) {
           abort(403, 'Sorry !! You are Unauthorized to add any class !');
       }
       $coordinators = User::where('user_type', User::USER_TYPE_COORDINATOR)->get();
       
        return view('class.create', [
            'teachers' => User::where('user_type', User::USER_TYPE_TEACHER)->get(),
            'coordinators' => $coordinators,
            'courses' => Course::all(),
            'tracks' => CourseTrack::all(),
            'levels' => CourseLevel::all()
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
        $new_class = new DaClass();
        $new_class->name = $request->name;
        $new_class->teacher_id = $request->teacher_id;
        $new_class->coordinator_id = $request->coordinator_id;
        $new_class->course_id = $request->course_id;
        $new_class->track_id = $request->track_id;
        $new_class->level_id = $request->level_id;
        $new_class->status = $request->status;
        $new_class->save();

        toastr()->success('Class created successfully.');
        return redirect()->route('class.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaClass  $daClass
     * @return \Illuminate\Http\Response
     */
    public function show(DaClass $daClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DaClass  $daClass
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('classes.edit')) {
           abort(403, 'Sorry !! You are Unauthorized to edit any class !');
       }
       $classInfo = DaClass::find($id);
       $courseWiseTracks = CourseTrack::where('course_id', $classInfo->course_id)->get();
       $trackWiseLevels = CourseLevel::where('track_id', $classInfo->track_id)->get();
       $coordinators = User::where('user_type', User::USER_TYPE_COORDINATOR)->get();
       
       
        return view('class.edit', [
            'class' => $classInfo,
            'teachers' => User::where('user_type', User::USER_TYPE_TEACHER)->get(),
            'coordinators' => $coordinators,
            'courses' => Course::all(),
            'tracks' => $courseWiseTracks, 
            'levels' => $trackWiseLevels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DaClass  $daClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DaClass::find($id)->update($request->all());

        toastr()->success('Class updated successfully.');
        return redirect()->route('class.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DaClass  $daClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(DaClass $daClass)
    {
        //
    }

    public function showClassDetails(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('classes.details')) {
            abort(403, 'Sorry !! You are Unauthorized to view class details !');
        }
        if(count($request->all()) >= 1){
            $clause = $attendance ='';
            if($request->student_name){
                $clause = $clause . "AND Ustudent.name Like '%$request->student_name%' ";
            }
            if($request->teacher_id){
                $clause = $clause . "AND teacher.id = '$request->teacher_id' ";
            }
            if($request->student_id){
                $clause = $clause . "AND student.student_id = '$request->student_id' ";
            }
            if($request->date){
                $day = date('l', strtotime($request->date));
                $attendance = $attendance . "AND attendance.date = '$request->date' ";
                $clause = $clause . "AND scheduled.day = '$day' ";
            }
            if($request->time){
                $clause = $clause . "AND scheduled.time = '$request->time:00'";
            }
            $classes = DB::select("SELECT attendance.status, scheduled.day, scheduled.time, class.name as className, teacher.name as instructor, Ustudent.name as studentName, Ustudent.email, student.student_id, student.id as std_id, parent.phone
            FROM class_schedules scheduled
            JOIN da_classes class ON (class.id = scheduled.class_id)
            JOIN users teacher ON (teacher.id = class.teacher_id)
            JOIN students student ON (student.class_id = class.id)
            JOIN parents parent ON (parent.user_id = student.parent_id)
            JOIN users Ustudent ON (Ustudent.id = student.user_id)
            LEFT JOIN student_attendances attendance ON (attendance.student_id = student.user_id $attendance)
            WHERE class.status = 1 and student.status = 1 $clause");
        }else{
            $classes = '';
        }

        $teachers = User::where('user_type', User::USER_TYPE_TEACHER)->where('status', 1)->get();

        return view('class.class-details', compact('classes', 'teachers'));
    }
}
