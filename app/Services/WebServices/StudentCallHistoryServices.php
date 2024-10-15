<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{StudentCallHistoryDao};

class StudentCallHistoryServices{

    protected $student_call_history_dao;
    
    public function __construct()
    {
        $this->student_call_history_dao = new StudentCallHistoryDao();
    }

    public function getStudentCallHistoryList($id)
    {
        return $this->student_call_history_dao->fetchStudentCallHistoryList($id);
    }
}
