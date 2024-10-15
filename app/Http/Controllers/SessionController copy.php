<?php

namespace App\Http\Controllers;

use App\Models\MeetingRecordingdetailsTbl;
use App\Models\ZoomUserAccountTbl;
use App\Models\StudentAttendance;
use App\Models\ClassSession;
use App\Models\DaClass;
use App\Models\ZoomRecordDA;
use App\Models\MeetingTbl;
use App\Models\Student;
use App\Models\StudentProject;
use App\Models\User;
use App\Models\StudentClassParticipant;
use App\Traits\Utils;
use App\Traits\validators\SessionValidator;
use App\Traits\ZoomMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class SessionController extends Controller
{
    use Utils, SessionValidator, ZoomMeeting;
    
    public function goToTeacherSession($id)
    {
        $class = DaClass::find($id);
        $todayDay = date('l');
        // dd($this->zoomServerToServerAccessTokenGenerate());
        
        $zoom_useraccount = ZoomUserAccountTbl::updateOrInsert(
            ['email' => auth()->user()->email],
            [
                'topic' => auth()->user()->zoom_topic,
                'meeting_id' => auth()->user()->zoom_meeting_id, 
                'password' => auth()->user()->zoom_password, 
                'is_active' => 0
            ]
            )->first();
        // $data = array(
        //     'topic' => auth()->user()->zoom_topic,
        //     'duration' => 60,
        //     'agenda' => "Coding Class",
        //     'start_time' => "20:30",
        //     'host_video' => "1",
        //     'participant_video' => "1",
        // );
        // $response = $this->create($data);
        // dd($zoom_useraccount);
        // $zoom_useraccount = ZoomUserAccountTbl::find(3);
        if($class->teacher_id == auth()->user()->id){
            $session_id = substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6/strlen($x)) )),1,6);
            $today = Carbon::now()->addHours(6)->format('Y-m-d');
            
            $time = Carbon::now()->addHours(6);
            $start_time = $time->format("H:i:s A");
            $end_time = $time->addHours(1)->format("H:i:s A");
            
            $session_class_query = ClassSession::where('session_date', $today)
                ->where('class_id', $id);
            $meeting_tbl_query = MeetingTbl::where('start_date', $today)
                ->where('end_date', $today)
                ->where('course_id', $id);

            $count = $session_class_query->count();
            
            if($count >0){
                $find = $session_class_query->update([
                    'session_id' => $session_id
                ]);
                $find2 = $meeting_tbl_query->update([
                    'client_session_id' => $session_id
                ]);
                $new_session = ClassSession::where('session_date', $today)
                    ->where('session_id', $session_id)
                    ->where('class_id', $id)->first();
                $new_meeting = MeetingTbl::where('start_date', $today)
                    ->where('client_session_id', $session_id)
                    ->where('course_id', $id)->first();
                    
            }else{
                // --------------------- its start for meeting create in zoom panel ----------------
                    $scheduleTime = '';
                if($class->isZoomAutomated == 1){
                    foreach($class->class_schedules as $schedule){
                        if($schedule->day == $todayDay){
                            $scheduleTime = $schedule->time;
                        }
                    }
                    $data = array(
                        'topic' => auth()->user()->zoom_topic,
                        'duration' => 120,
                        'agenda' => "Coding Class",
                        'start_time' => $scheduleTime,
                        'teacherEmail' => auth()->user()->email,
                        'host_video' => 1,
                        'participant_video' => 1,
                    );
                    $response = $this->create($data);

                    $uuid = (!empty($response['data']['uuid']) ? $response['data']['uuid'] : '');
                    $start_url = (!empty($response['data']['start_url']) ? $response['data']['start_url'] : '');
                    $join_url = (!empty($response['data']['join_url']) ? $response['data']['join_url'] : '');
                    $zoom_response = json_encode($response['data']);
                    $zoomResponseStatus = $response['success']; 
                    $zoom_pmi = (!empty($response['data']['id']) ? $response['data']['id'] : '');
                }else{
                    $uuid = '';
                    $start_url = '';
                    $join_url = '';
                    $zoom_response = null;
                    $zoomResponseStatus = '';
                    $zoom_pmi = 0;
                }
                
                // --------------------- its close for meeting create in zoom panel ----------------
                    $new_meeting = new MeetingTbl();
                    $new_meeting->title             =  'Live Class';
                    $new_meeting->course_id         =  $id;
                    $new_meeting->meeting_id        =  $zoom_useraccount->meeting_id;
                    $new_meeting->client_session_id =  $session_id;
                    $new_meeting->meeting_password  =  $zoom_useraccount->password;
                    $new_meeting->meetingid_topic   =  $zoom_useraccount->topic;
                    $new_meeting->meeting_date      =  $today;
                    $new_meeting->start_date        =  $today;
                    $new_meeting->end_date          =  $today;
                    $new_meeting->start_time        =  $start_time;
                    $new_meeting->end_time          =  $end_time;
                    $new_meeting->is_host           =   0;
                    $new_meeting->status            =   1;
                    $new_meeting->is_meetingdone    =   0;
                    $new_meeting->enterprise_id     =  '1';
                    $new_meeting->created_by        =  '1';
                    $new_meeting->save();
    
                    $new_session = new ClassSession();
                    $new_session->session_started = $scheduleTime; //$start_time;
                    $new_session->session_date = $today;
                    $new_session->session_id = $session_id;
                    $new_session->class_id = $id;
                    $new_session->teacher_id = auth()->user()->id;
                    $new_session->status = 'Active';
                    $new_session->uuid    =   $uuid;
                    $new_session->start_url    =   $start_url;
                    $new_session->join_url    =   $join_url;
                    $new_session->zoom_response    =   $zoom_response;
                    $new_session->class_status    =   0;
                    $new_session->zoom_pmi    =   $zoom_pmi;
                    $new_session->save();
            }

            $attendances = StudentAttendance::where('class_id', $id)
                    ->where('date', $today)
                    ->where('teacher_id', auth()->user()->id)
                    ->get();

            $student_project_query = StudentProject::where('class_id', $id)
                        ->where('teacher_id', auth()->user()->id) 
                        ->where('is_homework', 0);
            $projects = $student_project_query->get();

            $single_project = $student_project_query->first();

            $from = 'session';
            $project_name = (empty($single_project) ? '' : $single_project->project->name);

            
            $studentHomeworkProjectQuery = StudentProject::where('class_id', $id)
                        ->where('teacher_id', auth()->user()->id) 
                        ->where('is_homework', 1);
            $homeProjects = $studentHomeworkProjectQuery->get();

            $singleHomeworkProject = $studentHomeworkProjectQuery->first();

            $singleHomeworkProjectName = (empty($singleHomeworkProject) ? '' : $singleHomeworkProject->project->name);

            return view('sessions.teacher', compact('id', 'new_session', 'attendances', 'projects', 'new_meeting', 'from', 'project_name', 'singleHomeworkProjectName', 'homeProjects'));
        }else{
            return abort(403);
        }
    }

    public function goToStudentSession($id)
    {
        $student = Student::where('user_id', auth()->user()->id)
                  ->where('class_id', $id)->first();
        if($student != NULL){
        $today = Carbon::now()->addHours(6)->format('Y-m-d');

        $new_session = ClassSession::where('session_date', $today)
            ->where('class_id', $id)->first();
        $attendance = StudentAttendance::where('class_id', $id)
            ->where('date', $today)
            ->where('student_id', auth()->user()->id)
            ->first();
        $projects = StudentProject::where('class_id', $id)
                    ->where('student_id', auth()->user()->id)
                    ->get();
        $new_meeting = MeetingTbl::where('meeting_date', $today)
                    ->where('start_date', $today)
                    ->where('course_id', $id)->first();
        // $meeting_recording_details = MeetingRecordingdetailsTbl::where('meeting_rowid', $new_meeting->id)->first();
        // if(!empty($meeting_recording_details)){
        //     $full_iframe_arrays = explode(' ', $meeting_recording_details->vimeo_embed_html);
        //     $iframe_links = explode('"', $full_iframe_arrays[1]);
        //     $new_session->recording_link = $iframe_links[1];
        //     $new_session->save();
        // }
        return view('sessions.student', compact('id', 'new_session', 'attendance', 'projects', 'today', 'new_meeting'));
        }else{
            return abort(403);
        }
    }

    public function saveStartSessionData(Request $request)
    {
        $start_time = Carbon::now()->addHours(6)->format("H:i:s A");
        $end_time = Carbon::now()->addHours(7)->format("H:i:s A");
        
        $session = ClassSession::where('session_id', $request->session_id)->first();
        $session->session_started = $start_time;
        $session->session_ended = $end_time;
        $session->status = 'Active';
        $session->save();

        return $session;
    }

    public function saveEndSessionData($id)
    {
        $end_time = Carbon::now()->addHours(6)->format("H:i:s A");
        $session = ClassSession::find($id);
        $meeting = MeetingTbl::where('client_session_id', $session->session_id)->first();
        // $meeting_recording_details = MeetingRecordingdetailsTbl::where('meeting_rowid', $meeting->id)->first();

        $session->session_ended =  $end_time;
        $session->status          =  'Completed';
        $session->comments      = 'No Comments';
        // if($meeting_recording_details){
        //     $full_iframe_arrays = explode(' ', $meeting_recording_details->vimeo_embed_html);
        //     $iframe_links = explode('"', $full_iframe_arrays[1]);
        //     $session->recording_link = $iframe_links[1];
        // }
        $session->save();

        toastr()->success('Your Session Has Ended.');

    return redirect()->route('session-teacher', ['id' => $session->class_id]);
    }

    public function showAllSessionsForStudent($id)
    {
        $classes = Student::
        join('class_sessions','students.class_id', '=', 'class_sessions.class_id')
        ->where('students.user_id', auth()->user()->id)
        ->where('class_sessions.class_id', $id)
        ->where('class_sessions.status', 'Completed')
        ->orderBy('class_sessions.session_date', 'DESC')
        ->get();

        return view('sessions.all-sessions-student', compact('classes'));
    }

    public function goToStudentSessionSpecific(Request $request)
    {
        $id = $request->id;
        $today = $request->date;  //date is today because 'today' variable has been used in the view previously.
        $student = Student::where('user_id', auth()->user()->id)
                  ->where('class_id', $request->id)->first();
        if($student != NULL){
        $new_session = ClassSession::where('session_date', $today)
            ->where('class_id', $id)->first();

        $attendance = StudentAttendance::where('class_id', $id)
            ->where('date', $today)
            ->where('student_id', auth()->user()->id)
            ->first();
        $projects = StudentProject::where('student_id', auth()->user()->id)
                    ->where('class_id', $id)
                    ->get();
        $new_meeting = MeetingTbl::where('meeting_date', $today)
                    ->where('start_date', $today)
                    ->where('course_id', $id)->first();

        // $meeting_recording_details = MeetingRecordingdetailsTbl::where('meeting_rowid', $new_meeting->id)->first();
        // if(!empty($meeting_recording_details)){
        //     $full_iframe_arrays = explode(' ', $meeting_recording_details->vimeo_embed_html);
        //     $iframe_links = explode('"', $full_iframe_arrays[1]);
        //     $new_session->recording_link = $iframe_links[1];
        //     $new_session->save();
        // }
        
        return view('sessions.student', compact('id', 'new_session', 'attendance', 'projects', 'today', 'new_meeting'));
        }else{
            return abort(403);
        }
    }

    public function showSessionDetailsToParent(Request $request)
    {
        $students = Student::
        join('class_sessions','students.class_id', '=', 'class_sessions.class_id')
        ->where('students.user_id', $request->student_id)
        ->where('class_sessions.class_id', $request->class_id)
        ->where('class_sessions.status', 'Completed')
        ->orderBy('class_sessions.session_date', 'DESC')
        ->get();
        return view('sessions.all-sessions-parent', compact('students'));
    }

    public function goToParentSessionSpecific(Request $request)
    {
        $class_id = $request->class_id;
        $student_id = $request->student_id;
        $today = $request->date;

        $new_session = ClassSession::where('session_date', $today)
                    ->where('class_id', $class_id)
                    ->first();
        $attendance = StudentAttendance::where('class_id', $class_id)
                    ->where('date', $today)
                    ->where('student_id', $student_id)
                    ->first();
        $projects = StudentProject::where('class_id', $class_id)
                    ->where('student_id', $student_id)
                    ->get();
        return view('sessions.parent', compact('today', 'new_session', 'attendance', 'projects'));
    }

    public function checkIfSessionStarted($id)
    {
        $today = Carbon::now()->addHours(6)->format('Y-m-d');
        $new_session = ClassSession::where('session_date', $today)
                        ->where('class_id', $id)->first();
                        
        return $new_session;
    }

    public function saveVideoClassRecording()
    {
        if(auth()->user()->user_type ==  'Super-Admin'){
            $sessions = ClassSession::select('session_id')
                        ->where('status', 'Completed')
                        ->whereNull('recording_link')
                        ->get();
            $class_recordings = MeetingTbl::join('meetinghost_details_tbl', 'meetinghost_details_tbl.meeting_rowid', 'meeting_tbl.id')
                               ->join('meeting_recordingdetails_tbl', 'meeting_recordingdetails_tbl.meeting_uuid', 'meetinghost_details_tbl.meeting_uuid')
                               ->whereIn('meeting_tbl.client_session_id', $sessions)
                               ->whereNotNull('meetinghost_details_tbl.meeting_uuid')
                               ->get();
            foreach($sessions as $session){
                foreach($class_recordings as $class_recording){
                    if($session->session_id == $class_recording->client_session_id){
                        $full_iframe_arrays = explode(' ', $class_recording->vimeo_embed_html);
                        $iframe_links = explode('"', $full_iframe_arrays[1]);
                        ClassSession::where('session_id', $session->session_id)
                                    ->update(['recording_link'=> $iframe_links[1]]);
                    }
                }
            }
            return view('pages.save-video');
        }else{
            return view('pages.error-404');
        }
    }

    public function saveSessionAsCompleted($id)
    {
      $time = Carbon::now()->addHours(6)->format("H:i:s A");
       
      ClassSession::where('session_id', $id)
        ->update([
            'session_ended'=> $time,
            'status' => 'Completed', 
            'comments' => 'No Comments'
        ]);

       return 1;
    }
    
    public function updateRecordingList(Request $request)
    {
        if(empty($request->email) && empty($request->date)){
            $recordings = "";
            $sessions = "";
        }else{
            $query = ZoomRecordDA::where('flag', 0);
            if($request->email){
                $query = $query->where('topic', $request->email);
            }
            if($request->date){
                $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
                $added_date = Carbon::parse($date)->addDay()->format('Y-m-d');
    
                $query = $query->whereBetween('start_time', [$date.' 00:00:00', $added_date.' 00:00:01']);
            }
            $recordings = $query->get();
            if($request->email){
                $getUserInfo = User::where('email', $request->email)->where('user_type', 'Teacher')->first();
                $getTeacherId = $getUserInfo->id;
            }
            
            if($request->date && $request->email){
                $sessions = ClassSession::whereNull('recording_link')
                            ->where('session_date', $request->date)
                            ->where('teacher_id', $getTeacherId)
                            ->orderBy('session_date', 'DESC')
                            ->get();
            }elseif($request->date){
                $sessions = ClassSession::whereNull('recording_link')
                            ->where('session_date', $request->date)
                            ->orderBy('session_date', 'DESC')
                            ->get();
            }elseif($request->email){
                $sessions = ClassSession::whereNull('recording_link')
                            ->where('teacher_id', $getTeacherId)
                            ->orderBy('session_date', 'DESC')
                            ->get();
            }else{
                $sessions = ClassSession::whereNull('recording_link')
                            ->orderBy('session_date', 'DESC')
                            ->get();
            }
            
        }
        
        return view('sessions.recording-maping', compact('recordings', 'sessions'));
    }

    public function updateLiveVideoSingle(Request $request)
    {
        ZoomRecordDA::updateOrInsert(
            ['id' => $request->recording_id],
            ['flag' => 1]
        );
        
        if($request->is_trial == 'false'){
            $full_iframe_array = explode(' ', $request->vimeo_embed_html);
            $iframe_links = explode('"', $full_iframe_array[1]);
            $recording_link = $iframe_links[1];

            ClassSession::updateOrInsert(
                ['id' => $request->session_id],
                ['recording_link' => $recording_link]
            );
        }

        return 1;
    }

    public function updateLiveVideo(Request $request)
    {
        foreach($request->recordings as $key => $recording){
            if(!empty($recording['is_trial'])){
                ZoomRecordDA::updateOrInsert(
                    ['id' => $recording['recording_id']],
                    ['flag' => 1]
                );
            }
        }
        toastr()->success('Removed All Selected Trial Class Recordings.');

        return redirect()->back();
    }

    public function createSession()
    {
        $classes = DaClass::where('status', 1)->get();

        return view('sessions.create', compact('classes'));
    }

    public function getClassRecordings(Request $request)
    {
        $recordings = ZoomRecordDA::where('flag', 0)
                    ->where('recording_start', '>=', $request->date. ' 00:00:00')
                    ->where('recording_start', '<=', $request->date. ' 23:59:59')
                    ->get();

        foreach($recordings as $recording){
            $recording->meeting_id = User::where('email', $recording->topic)->first()->name;;
        }

        return $recordings;
    }

    public function createCustomSession(Request $request)
    {
        $validator = $this->validateCustomSession($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $recordingDetails = ZoomRecordDA::where('id', $request->classRecording)->first();

        $full_iframe_array = explode(' ', $recordingDetails->vimeo_embed_html);
        $iframe_links = explode('"', $full_iframe_array[1]);
        $recording_link = $iframe_links[1];

        ClassSession::create([
            'session_started' => $request->startTime,
            'session_ended' => date('h:i:s A', strtotime($request->startTime . '+1 hours')),
            'session_date' => $request->meetingDate,
            'session_id' => $this->getUniqueId(6),
            'class_id' => $request->classId,
            'teacher_id' => DaClass::find($request->classId)->teacher_id,
            'status' => 'Completed',
            'comments' => 'Created Manually',
            'recording_link' => $recording_link
        ]);
        $recordingDetails->flag = 1;
        $recordingDetails->save();
        
        toastr()->success('Session Created Successfully.');

        return back();
    }

    public function passed_recording(Request $request){
        $meeting_date = $request->meeting_date;
        $recordings = array();
        if($meeting_date){
            $recordings = ClassSession::with('sessionClass', 'teacher')
                        ->where('session_date', $meeting_date)
                        ->orderBy('session_date', 'DESC')
                        ->get();
        }
        
        $allResults = array(
            'recordings' => $recordings,
            'meeting_date' => $meeting_date,
        );
        return view('sessions.passed_recording', compact('allResults'));
    }

    public function passed_recording_edit($id){
        $getPassedRecording = ClassSession::with('sessionClass', 'teacher')
                    ->where('id', $id)
                    ->first();
        $session_date = $getPassedRecording->session_date;

        $query = ZoomRecordDA::where('created_date', $session_date);
        $recordings = $query->get();
       
        
        $allResults = array(
            'getPassedRecording' => $getPassedRecording,
            'recordings' => $recordings
        );
        return view('sessions.passed_recording_edit', compact('allResults'));
    }
    
    public function passed_recording_update(Request $request){
        $da_record_id = $request->da_record_id;
        $getZoomRecordDAInfo = ZoomRecordDA::where('id', $da_record_id)->first();
        
        ZoomRecordDA::updateOrInsert(
            ['id' => $da_record_id],
            ['flag' => 1]
        );
        
        if($getZoomRecordDAInfo){
            $full_iframe_array = explode(' ', $getZoomRecordDAInfo->vimeo_embed_html);
            $iframe_links = explode('"', $full_iframe_array[1]);
            $recording_link = $iframe_links[1];

            ClassSession::updateOrInsert(
                ['id' => $request->id],
                ['recording_link' => $recording_link]
            );
        }
        toastr()->success('Updated Successfully.');
        return redirect("passed-recording?meeting_date=$getZoomRecordDAInfo->created_date");
    }

    
    public function missing_session(Request $request){
        $date = $request->date;
        $getMissingSessionData = array();
        if($date){
            $day = date('l', strtotime($date));
            $getMissingSessionData = DB::select("SELECT csh.class_id, cs.teacher_id, csh.time, cs.name, cs.status, user.name teacherName
                                FROM `class_schedules` csh
                                join da_classes cs on (cs.id = csh.class_id and cs.teacher_id = csh.teacher_id and cs.status = 1 and csh.teacher_id != 3)
                                join users user on (user.id = cs.teacher_id)
                                where csh.day = '$day' and DATE(cs.created_at) >= '$date' and csh.class_id not in (
                                    select ses.class_id from class_sessions ses where ses.session_date = '$date'
                                )
                                order by user.name asc
                            ");
        }
        
        $allResults = array(
            'getMissingSessionData' => $getMissingSessionData,
            'date' => $date,
        );
        return view('sessions.missing_session', compact('allResults'));
    }
    
    public function add_new_session(){
        $getTeacherInfo = User::where('user_type', 'Teacher')->get();
        $allResults = array(
            'getTeacherInfo' => $getTeacherInfo,
        );
        return view('sessions.add_new_session', compact('allResults'));
    }

         // ================ its for teacher wise classes ==============
    public function teacherWiseClasses(Request $request){
        $teacher_id = $request->teacher_id;
        $teacherWiseClasses = DaClass::where('teacher_id', $teacher_id)->get();
        
        echo "<option value=''>-- select one --</option>";
       foreach ($teacherWiseClasses as $value) {
           echo "<option value='$value->id'>$value->name</option>";
       }
    }

    public function session_save(Request $request){
        $teacher_id = $request->teacher_id;
        $session_date = $request->session_date;
        $session_started = $request->session_started;
        $session_ended = date('H:i:s', strtotime($session_started . '+1 hours'));
        
        ClassSession::create([
            'session_started' => $session_started,
            'session_ended' => $session_ended,
            'session_date' => $session_date,
            'session_id' => $this->getUniqueId(6),
            'class_id' => $request->class_id,
            'teacher_id' => $teacher_id,
            'status' => 'Completed',
            'comments' => 'Created Manually',
            'recording_link' => null,
        ]);

        toastr()->success('Added Successfully.');
        return redirect("add-new-session");
    }

    public function classSessionParticipantStore(Request $request){
        $student_id = $request->student_id;
        $class_session_id = $request->class_session_id;
        
        StudentClassParticipant::create([
            'student_id' => $student_id,
            'class_session_id' => $class_session_id,
        ]);
        return true;
    }

    public function classSessionStart(Request $request){
        $class_session_id = $request->class_session_id;
        
        ClassSession::where('id', $class_session_id)->update([
            'class_status' => 1,
        ]);
        return true;
    }


}
