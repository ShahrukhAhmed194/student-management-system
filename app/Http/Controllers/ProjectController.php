<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseTrack;
use App\Models\Project;
use App\Models\TrackInfo;
use App\Models\LevelInfo;
use App\Models\Badges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
        if (is_null($this->user) || !$this->user->can('projects.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any projects !');
        }

        return view('project.index', [
            'projects' => Project::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('projects.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any projects !');
        }
        
        return view('project.create', [
            'courses'   => Course::all(),
            'tracks'    => CourseTrack::all(),
        ]);
    }
    
        // ================ its for track wise level ==============
    public function trackWiseLevel(Request $request){
        $track_id = $request->track_id;
        $trackWiseLevels = CourseLevel::where('track_id', $track_id)->get();
        
        echo "<option value=''>-- select one --</option>";
        foreach ($trackWiseLevels as $value) {
            echo "<option value='$value->id'>$value->level_num</option>";
        }
    }

        // ================ its for course wise track ==============
    public function courseWiseTrack(Request $request){
        $course_id = $request->course_id;
        $courseWiseTracks = CourseTrack::where('course_id', $course_id)->get();
        
        echo "<option value=''>-- select one --</option>";
        foreach ($courseWiseTracks as $value) {
            echo "<option value='$value->id'>$value->track_num</option>";
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
        
        Project::create([
            'name' => $request->name,
            'learning_outcomes' => $request->learning_outcomes,
            'link_teacher' => $request->link_teacher,
            'link_student_before' => $request->link_student_before,
            'link_student_after' => $request->link_student_after,
            'course_id' => $request->course_id,
            'track_id' => $request->track_id,
            'level_id' => $request->level_id,
            'is_homework' => isset($request->is_homework) ? 1 : 0,
            'notes' => $request->notes,
        ]);

        toastr()->success('Project created successfully.');
        return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('projects.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any projects !');
        }
        $projectInfo = Project::find($id);
        $courseWiseTracks = CourseTrack::where('course_id', $projectInfo->course_id)->get();
        $trackWiseLevels = CourseLevel::where('track_id', $projectInfo->track_id)->get();

        return view('project.edit', [
            'courses'   => Course::all(),
            'tracks'    => $courseWiseTracks,
            'levels'    => $trackWiseLevels,
            'project' => $projectInfo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Project::where("id", $id)->update([
            'name' => $request->name,
            'learning_outcomes' => $request->learning_outcomes,
            'link_teacher' => $request->link_teacher,
            'link_student_before' => $request->link_student_before,
            'link_student_after' => $request->link_student_after,
            'course_id' => $request->course_id,
            'track_id' => $request->track_id,
            'level_id' => $request->level_id,
            'is_homework' => isset($request->is_homework) ? 1 : 0,
            'notes' => $request->notes,
        ]);

        toastr()->success('Project updated successfully.');
        return redirect()->route('project.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
