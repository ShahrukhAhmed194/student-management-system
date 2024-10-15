<?php
namespace App\DAO\ApiDao;

use App\Models\Student;

class StudentApiDao{
    
    public function getStudentByUserId($user_id) {
      return Student::where('user_id', $user_id)->first();
    }

    public function getStudentById($student_id) {
      return Student::find($student_id);
    }

    
    public function getChildByParentUserId($user_id) {
      return Student::where('parent_id', $user_id)
            ->get();
    }
}