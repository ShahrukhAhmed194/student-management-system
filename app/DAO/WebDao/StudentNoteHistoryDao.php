<?php

namespace App\DAO\WebDao;

use App\Models\{StudentNoteHistories};

class StudentNoteHistoryDao{
    
    public function fetchNoteHistoriesOfStudent($id)
    {
        return StudentNoteHistories::where('student_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
    }
}
