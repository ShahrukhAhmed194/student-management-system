<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\DaClass;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassScheduleController extends Controller
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
        if (is_null($this->user) || !$this->user->can('class_schedule.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any schedule classes !');
        }
        return view('class-schedule.index', [
            'class_schedules' => ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')
                                ->where('da_classes.status', 1)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('class_schedule.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any class schedule !');
        }
        return view('class-schedule.create', [
            'classes' => DaClass::where('status', 1)->get()
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
        // ClassSchedule::create($request->all());
        ClassSchedule::create([
            'class_id' => $request->class_id,
            'teacher_id' => DaClass::find($request->class_id)->teacher_id,
            'day' => $request->day,
            'time' => $request->time
        ]);

        toastr()->success('Class schedule created successfully.');
        return redirect()->route('class-schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassSchedule  $classSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(ClassSchedule $classSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassSchedule  $classSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (is_null($this->user) || !$this->user->can('class_schedule.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any class schedule !');
        }

        $class_schedule = ClassSchedule::where('class_id', $id)
                          ->where('day', $request->day)->first();
        $classes = DaClass::where('status', 1)->get();

        return view('class-schedule.edit', compact('class_schedule', 'classes'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassSchedule  $classSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ClassSchedule::find($id)->update($request->all());
        ClassSchedule::find($id)->update([
            'class_id' => $request->class_id,
            'teacher_id' => DaClass::find($request->class_id)->teacher_id,
            'day' => $request->day,
            'time' => $request->time,
        ]);

        toastr()->success('Class schedule updated successfully.');
        return redirect()->route('class-schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassSchedule  $classSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassSchedule $classSchedule)
    {
        //
    }

    public function regularClassList()
    {
        return view('teacher.regular-class', [
            'classes' => ClassSchedule::join('da_classes', 'da_classes.id', 'class_schedules.class_id')
                    ->where('class_schedules.teacher_id', auth()->user()->id)
                    ->where('da_classes.status', 1)
                    ->orderBy('class_schedules.id', 'DESC')
                    ->get(),
        ]);
    }

    public function getStudentsPerClass($id){
        $students = Student::join('users', 'users.id', 'students.user_id')
                    ->where('students.class_id', $id)->where('students.status', 1)->get();
        if($students){
            return $students;
        }else{
            return '';
        }
    }
}
