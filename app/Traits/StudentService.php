<?php
namespace App\Traits;

use App\Models\Student;

trait StudentService{

    public function findStudentById($id){
  
        return Student::find($id);
    }
}