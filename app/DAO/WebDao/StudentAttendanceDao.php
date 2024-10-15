<?php

namespace App\DAO\WebDao;

use App\Models\{StudentAttendance};

class StudentAttendanceDao{
    
    public function fetchStudentAttendanceHistory($user_id)
    {
        $attendances = StudentAttendance::select('users.id', 'users.name', 'student_attendances.date', 
        'student_attendances.status', 'student_attendances.comments')
        ->join('students', 'students.user_id', 'student_attendances.student_id')
        ->join('users', 'users.id', 'students.user_id')
        ->where('student_attendances.student_id', $user_id)
        ->get();

        return $attendances;
    }
}
