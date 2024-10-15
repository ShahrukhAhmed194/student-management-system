<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{StudentNoteHistoryDao};

class StudentNoteHistoryServices{

    protected $student_note_history_dao;
    public function __construct()
    {
        $this->student_note_history_dao = new StudentNoteHistoryDao();
    }

    public function getNoteHistoryOfStudent($id)
    {
        return $this->student_note_history_dao->fetchNoteHistoriesOfStudent($id);
    }
}
