<?php

namespace App\Http\Controllers;

use App\Models\CourseLevel;
use Illuminate\Http\Request;
use App\Services\WebServices\{CourseLevelServices, StudentServices};

class CourseLevelController extends Controller
{
    protected $course_level_services, $student_services;
    
    public function __construct()
    {
        $this->course_level_services = new CourseLevelServices();
        $this->student_services = new StudentServices();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CourseLevel::create($request->all());

        toastr()->success('Course level created successfully.');
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseLevel  $courseLevel
     * @return \Illuminate\Http\Response
     */
    public function show(CourseLevel $courseLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseLevel  $courseLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseLevel $courseLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseLevel  $courseLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseLevel $courseLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseLevel  $courseLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseLevel $courseLevel)
    {
        //
    }

    public function getTrackLevelForRoadMap($id)
    {
        $getTrackLevels = $this->course_level_services->getCourseTrackLevelForRoadMap();
        $student =  $this->student_services->getStudentByID($id);

        return view('students.tabs.coding-program-roadmap', compact('getTrackLevels', 'student'));
    }
}
