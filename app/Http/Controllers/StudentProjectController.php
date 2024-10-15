<?php

namespace App\Http\Controllers;

use App\Models\DaClass;
use App\Models\Project;
use App\Models\Student;
use App\Models\StudentProject;
use App\Models\StudentRewardPoint;
use App\Models\RewardPointsStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('web')->user()->can('projectassesment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view project assessment list !');
        }
        return view('project.assesment.index', [
            'assesments' => StudentProject::where('teacher_id', auth()->user()->id)
                            ->where('is_homework', 0)
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
        if (!auth('web')->user()->can('projectassesment.add')) {
            abort(403, 'Sorry !! You are Unauthorized to create project assessment !');
        }
        
        $query = StudentProject::where('class_id', $request->class_id)
                ->where('teacher_id', auth()->user()->id)
                ->where('project_id', $request->project_id);
        $count = $query->count();
        $from = $request->from ;
        $classes  = DaClass::where('teacher_id', auth()->user()->id)
                    ->where('status', 1)->get();
                    
        $track_ids = array();
        if(auth()->user()->track_ids != null){
            $track_ids = json_decode(auth()->user()->track_ids);
        }
        $projects = Project::whereIn('track_id', $track_ids)->where('is_homework', 0)->get();
        

        if ($request->class_id && $request->project_id){
            if($count == 0){
                $students = Student::where('class_id', $request->class_id)
                ->where('status', 1)->get();
            }else{
                $students = $query->get();
            }

            $projectInfo = Project::find($request->project_id);

            $selected = [
                'class_id' => $request->class_id,
                'teacher_id' => auth()->user()->id,
                'project_id'  => $request->project_id,
                'is_homework'  => $projectInfo->is_homework
            ];
        }else{
            $students = [];
            $selected = [
                'class_id' => "",
                'teacher_id' => "",
                'project_id'  => "",
                'is_homework'  => ""
            ];
        }

        return view('project.assesment.create', compact('classes', 'projects', 'students', 'selected', 'count', 'from'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assesments.*.project_status' => 'required',
            'assesments.*.project_assesment' => 'required',
            'assesments.*.comments' => 'required',
        ]);
        if ($validator->fails()) {
            toastr()->error('Please fill all the fields.');
            return redirect()->back()->withInput();
        }
        if ($request->has('project_status') || $request->has('project_assesment') || $request->has('comments')) {
        
        }
        foreach ($request->assesments as $assesment) {

            $student_id = $assesment['student_id'];
            $project_status = @$assesment['project_status'];
            $project_assesment = @$assesment['project_assesment'];
            
            // ----------------- its for student reward point -------------
            $this->storeStudentRewardPoint($student_id, $project_status, $project_assesment);
            // ----------------- its for student reward point -------------

            StudentProject::updateOrInsert(
                [   'student_id' => $assesment['student_id'],
                    'project_id' => $request->project_id,
                    'class_id' =>   $request->class_id,
                    'teacher_id' => $request->teacher_id,
                    'is_homework' => $request->is_homework ],
                ['project_status' => $assesment['project_status'],
                 'project_assesment' => $assesment['project_assesment'],
                  'comments' => $assesment['comments'],
                  'is_homework' => $request->is_homework,
                  'created_at' => date('Y-m-d H:i:s')
                  ]
            );
        }

        toastr()->success('Student project assesment submitted successfully.');
        if($request->from == 'session'){
            return redirect()->route('session-teacher', ['id' => $request->class_id]);
        }else{
            if($request->is_homework == 0){
                return redirect()->route('project-assesment.index');
            }elseif($request->is_homework == 1){
                return redirect('homework');
            }
        }    
    }

    public function storeStudentRewardPoint($student_id, $project_status, $project_assesment){

        $points = $existsRewardPoint = 0;

        $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
        if($existsRewardInfo){
            $existsRewardPoint = $existsRewardInfo->points;   
        }

        if($project_status == "DID_NOT_START"){
          $didNotStartPoint = RewardPointsStructure::where('type', 'DID_NOT_START')->first();
            $points = ($existsRewardPoint+$didNotStartPoint->points);
        }elseif($project_status == "IN_PROGRESS"){
          $inprogressPoint = RewardPointsStructure::where('type', 'IN_PROGRESS')->first();
            $points = ($existsRewardPoint+$inprogressPoint->points);
        }elseif($project_status == "COMPLETE"){
          $completePoint = RewardPointsStructure::where('type', 'COMPLETE')->first();
            $points = ($existsRewardPoint+$completePoint->points);
        }else{
            $points = $existsRewardPoint;
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


        $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
        if($existsRewardInfo){
            $existsRewardPoint = $existsRewardInfo->points;   
        }
        if($project_assesment == "BELOW_AVERAGE"){
          $bellowAveragePoint = RewardPointsStructure::where('type', 'BELOW_AVERAGE')->first();
            $points = ($existsRewardPoint+$bellowAveragePoint->points);
        }elseif($project_assesment == "AVERAGE"){
          $averagePoint = RewardPointsStructure::where('type', 'AVERAGE')->first();
            $points = ($existsRewardPoint+$averagePoint->points);
        }elseif($project_assesment == "GOOD"){
          $goodPoint = RewardPointsStructure::where('type', 'GOOD')->first();
            $points = ($existsRewardPoint+$goodPoint->points);
        }elseif($project_assesment == "EXCELLENT"){
          $excellentPoint = RewardPointsStructure::where('type', 'EXCELLENT')->first();
            $points = ($existsRewardPoint+$excellentPoint->points);
        }else{
            $points = $existsRewardPoint;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentProject  $studentProject
     * @return \Illuminate\Http\Response
     */
    public function show(StudentProject $studentProject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentProject  $studentProject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth('web')->user()->can('projectassesment.edit') && !auth('web')->user()->can('homework.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit project assessment !');
        }
        
        $studentProject = StudentProject::find($id);

        return view('project.assesment.edit', [
            'classes' => DaClass::where('teacher_id', auth()->user()->id)
                        ->where('status', 1)->get(),
            'assesment' => $studentProject,
            'projects' => Project::all(),
            'students' => Student::where('class_id', $studentProject->class_id)
                          ->where('status', 1)->get(),
            'selected' => [
                'class_id' => $studentProject->class_id,
                'teacher_id' => DaClass::find($studentProject->class_id)->teacher_id,
                'project_id'  => $studentProject->project_id,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentProject  $studentProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $previousPoint = 0;
        $studentProject = StudentProject::find($id);
        $student_id = $studentProject->student_id;
        $previous_project_status = $studentProject->project_status;
        $previous_project_assesment = $studentProject->project_assesment;
        $previous_project_statusPoint = RewardPointsStructure::where('type', $previous_project_status)->first();
        $previous_project_assesmentPoint = RewardPointsStructure::where('type', $previous_project_assesment)->first();
        if($previous_project_statusPoint || $previous_project_assesmentPoint){
            $previousPoint = (@$previous_project_statusPoint->points+@$previous_project_assesmentPoint->points);
        }
        
        $project_status = $request->project_status;
        $project_assesment = $request->project_assesment;       

        $this->updateStudentRewardPoint($student_id, $project_status, $project_assesment, $previousPoint);

        $studentProject->update([
            'project_status' => $request->project_status,
            'project_assesment' => $request->project_assesment,
            'comments'  => $request->comments
        ]);

        toastr()->success('Student project assesment updated successfully.');
        if($studentProject->is_homework == 0){
            return redirect()->route('project-assesment.index');
        }else{
            return redirect('homework');
        }
    }

    
    public function updateStudentRewardPoint($student_id, $project_status, $project_assesment, $previousPoint){

        $points = $existsRewardPoint = 0;

        $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
        if($existsRewardInfo){
            $existsRewardPoint = $existsRewardInfo->points;   
        }

        if($project_status == "DID_NOT_START"){
          $didNotStartPoint = RewardPointsStructure::where('type', 'DID_NOT_START')->first();
            $points = ($existsRewardPoint+$didNotStartPoint->points);
        }elseif($project_status == "IN_PROGRESS"){
          $inprogressPoint = RewardPointsStructure::where('type', 'IN_PROGRESS')->first();
            $points = ($existsRewardPoint+$inprogressPoint->points);
        }elseif($project_status == "COMPLETE"){
          $completePoint = RewardPointsStructure::where('type', 'COMPLETE')->first();
            $points = ($existsRewardPoint+$completePoint->points);
        }else{
            $points = $existsRewardPoint;
        }

        if($existsRewardInfo){
            $rewardData = StudentRewardPoint::where("student_id", $student_id)->update([
                "points" => $points-$previousPoint,
            ]); 
        }else{
            $rewardData = StudentRewardPoint::create([
                "student_id" => $student_id,
                "points" => $points-$previousPoint,
            ]);
        }


        $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
        if($existsRewardInfo){
            $existsRewardPoint = $existsRewardInfo->points;   
        }
        if($project_assesment == "BELOW_AVERAGE"){
          $bellowAveragePoint = RewardPointsStructure::where('type', 'BELOW_AVERAGE')->first();
            $points = ($existsRewardPoint+$bellowAveragePoint->points);
        }elseif($project_assesment == "AVERAGE"){
          $averagePoint = RewardPointsStructure::where('type', 'AVERAGE')->first();
            $points = ($existsRewardPoint+$averagePoint->points);
        }elseif($project_assesment == "GOOD"){
          $goodPoint = RewardPointsStructure::where('type', 'GOOD')->first();
            $points = ($existsRewardPoint+$goodPoint->points);
        }elseif($project_assesment == "EXCELLENT"){
          $excellentPoint = RewardPointsStructure::where('type', 'EXCELLENT')->first();
            $points = ($existsRewardPoint+$excellentPoint->points);
        }else{
            $points = $existsRewardPoint;
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentProject  $studentProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentProject $studentProject)
    {
        //
    }
    
    public function homework()
    {
        if (!auth('web')->user()->can('homework.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view homework list !');
        }
        return view('project.homework.index', [
            'Homeworks' => StudentProject::where('teacher_id', auth()->user()->id)
                                            ->where('is_homework', 1)
                                            ->get()
        ]);
    }
    public function homeworkCreate(Request $request)
    {
        if (!auth('web')->user()->can('homework.add')) {
            abort(403, 'Sorry !! You are Unauthorized to create homework !');
        }
        
        $query = StudentProject::where('class_id', $request->class_id)
                ->where('teacher_id', auth()->user()->id)
                ->where('project_id', $request->project_id);
        $count = $query->count();
        $from = $request->from ;
        $classes  = DaClass::where('teacher_id', auth()->user()->id)
                    ->where('status', 1)->get();
                    
        $track_ids = array();
        if(auth()->user()->track_ids != null){
            $track_ids = json_decode(auth()->user()->track_ids);
        }
        $projects = Project::whereIn('track_id', $track_ids)->where('is_homework', 1)->get();
        

        if ($request->class_id && $request->project_id){
            if($count == 0){
                $students = Student::where('class_id', $request->class_id)
                ->where('status', 1)->get();
            }else{
                $students = $query->get();
            }
            $projectInfo = Project::find($request->project_id);
            
            $selected = [
                'class_id' => $request->class_id,
                'teacher_id' => auth()->user()->id,
                'project_id'  => $request->project_id,
                'is_homework'  => $projectInfo->is_homework
            ];
        }else{
            $students = [];
            $selected = [
                'class_id' => "",
                'teacher_id' => "",
                'project_id'  => "",
                'is_homework'  => "",
            ];
        }

        return view('project.homework.create', compact('classes', 'projects', 'students', 'selected', 'count', 'from'));     
    }
    
}
