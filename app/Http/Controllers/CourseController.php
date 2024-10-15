<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseTrack;
use App\Models\DaClass;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentProject;
use App\Models\StudentQuiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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
        if(is_null($this->user) || !$this->user->can('courses.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any course !');
        }
        return view(
            'courses.index',
            [
                'courses' => Course::all(),
                'course_tracks' => CourseTrack::all(),
                'course_levels' => CourseLevel::all(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Course::create($request->all());

        toastr()->success('Course created successfully.');
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function studentCourses()
    {
        $dayOfToday = Carbon::now()->format('l');
        $student = Student::where('user_id', auth()->user()->id)->first();
        // dd($student->user_id);
        // dd(StudentAttendance::where('student_id', $student->user_id)->get());

        return view('my.course', [
            'class' => DaClass::find($student->class_id),
            'student' => $student,
            'attendances' => StudentAttendance::where('student_id', $student->user_id)->get(),
            'projects' => StudentProject::where('student_id', auth()->user()->id)
                ->get(),
            'quizs' => StudentQuiz::where('student_id', auth()->user()->id)
                ->get(),
        ]);
    }
}
