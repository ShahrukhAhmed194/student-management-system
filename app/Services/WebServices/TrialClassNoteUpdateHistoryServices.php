<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{TrialClassNoteUpdateHistoryDao};

class TrialClassNoteUpdateHistoryServices{

    protected $trial_class_note_dao;

    public function __construct()
    {
        $this->trial_class_note_dao = new TrialClassNoteUpdateHistoryDao();
    }

    public function getNotesByTrialClassIdList($id_list)
    {
        return $this->trial_class_note_dao->fetchNotesByTrialClassIdList($id_list);
    }
}
