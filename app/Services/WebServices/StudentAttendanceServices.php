<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{StudentAttendanceDao, StudentDao};

class StudentAttendanceServices{

    protected $student_attendance_dao, $student_dao;

    public function __construct()
    {
        $this->student_dao = new StudentDao();
        $this->student_attendance_dao = new StudentAttendanceDao();
    }

    public function getStudentAttendanceHistory($id)
    {
        $student = $this->student_dao->fetchStudentByID($id);
        $attendances = $this->student_attendance_dao->fetchStudentAttendanceHistory($student->user_id);

        return $attendances;
    }
}
