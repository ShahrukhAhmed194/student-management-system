<?php

namespace App\DAO\WebDao;

use App\Models\StudentCallHistory;
use Illuminate\Support\Facades\DB;

class StudentCallHistoryDao{
    
    public function fetchStudentCallHistoryList($id)
    {
        $call_histories = StudentCallHistory::select('student_id', 'user_id', 'phone', DB::raw('DATE_ADD(created_at, INTERVAL 6 HOUR) as createdAt'))
        ->where('student_id', $id)
        ->orderBy('createdAt', 'desc')
        ->get();

        return $call_histories;
    }
}
