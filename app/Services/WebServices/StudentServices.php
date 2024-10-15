<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\StudentDao;

class StudentServices{

    protected $student_dao;

    public function __construct()
    {
        $this->student_dao = new StudentDao();
    }

    public function getTabsForStudentEditPage()
    {
        $tabs = [
            [
                'id' => 1,
                'name' => "Form",
                'route' => 'fetch-student',
                'icon' => 'ti-list-check'
            ],
            [
                'id' => 2,
                'name' => "Roadmap",
                'route' => 'fetch-roadmap',
                'icon' => 'ti-road-sign'
            ],
            [
                'id' => 3,
                'name' => "Notes",
                'route' => 'fetch-notes',
                'icon' => 'ti-notes'
            ],
            [
                'id' => 4,
                'name' => "Calls",
                'route' => 'fetch-calls',
                'icon' => 'ti-phone-call'
            ],
            [
                'id' => 5,
                'name' => "Attendance",
                'route' => 'fetch-attendance',
                'icon' => 'ti-calendar'
            ],
            [
                'id' => 6,
                'name' => "Payment",
                'route' => 'fetch-payment',
                'icon' => 'ti-credit-card'
            ],
            [
                'id' => 7,
                'name' => "Attachments",
                'route' => 'fetch-attachment',
                'icon' => 'ti-file'
            ],
        ];
        
        return $tabs;
    }

    public function getStudentByID($id)
    {
        return $this->student_dao->fetchStudentByID($id);
    }

    public function getAdmittedStudentList($request)
    {
        $filter = [
            'due_installments' => $request->due_installments,
            'email' => $request->email,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'due_date' => $request->is_due,
            'phone' => $request->phone,
            'filter' => $request->filter,
            'month' => $request->month,
        ];
        
        return $this->student_dao->fetchActiveStudentsList($filter);
    }













    // public function justForKeepSake(){
    //     $getTrackLevels = CourseLevel::select('course_levels.id', 'course_levels.track_id', 'course_levels.level_num', 'course_levels.duration', 'course_tracks.track_num')
    //                         ->join('course_tracks', 'course_tracks.id', '=', 'course_levels.track_id')->get();
        
    //     return view('students.edit', [
    //         'getTrackLevels'    => $getTrackLevels,
    //         'student' => Student::find($id),
    //         'classes' => DaClass::where('status', 1)->get(),
    //         'note_histories' => StudentNoteHistories::where('student_id', $id)->get(),
    //         'call_histories' => StudentCallHistory::where('student_id', $id)->orderBy('id', 'desc')->get(),
    //         'attachmentHistories' => StudentAttachmentHistory::where('student_id', $id)->orderBy('id', 'desc')->get(),
    //         'months' => $this->getMonthsList(),
    //     ]);
    // }
}
