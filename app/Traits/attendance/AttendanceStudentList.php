<?php

namespace App\Traits\attendance;

use Illuminate\Support\Facades\Http;
use App\Models\StudentAttendance;
use GuzzleHttp\Psr7\Request;
use App\Models\Student;

trait AttendanceStudentList{

    /**
     * Get student list of a perticular date and class
     * 
     * @param $request date and class id
     * @return lists
     */
    public function getStudentsForAttendance($request)
    {
        $lists['attendances'] = StudentAttendance::where('class_id', $request->class_id)
                            ->where('date', $request->date)
                            ->get();
        $lists['count'] = $lists['attendances']->count();

        if($lists['count'] < 1){
            $lists['attendances'] = StudentAttendance::where('class_id', $request->class_id)
                            ->groupby('student_id')
                            ->distinct()
                            ->get();
        }
        $lists['students'] = Student::where('class_id', $request->class_id)
                            ->where('status', 1)
                            ->get();
        $lists['selected'] = [
            'class_id' => $request->class_id,
            'teacher_id' => auth()->user()->id,
            'date'  => $request->date,
        ];

        return $lists;
    }

    /**
     * Get empty lists to show in attendance page 
     * before any data being searched
     * 
     * @param 
     * @return empty lists
     */
    public function getEmptyListsForAttendance()
    {
        $lists['attendances'] = [];
        $lists['count'] = 0;
        $lists['students'] = [];
        $lists['selected'] = [
            'class_id' => " ",
            'teacher_id' => " ",
            'date'  => " ",
        ];

        return $lists;
    }
}