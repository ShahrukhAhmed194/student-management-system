<?php

namespace App\DAO\WebDao;

use App\Models\{NoteUpdateHistory};

class TrialClassNoteUpdateHistoryDao{
    
    public function fetchNotesByTrialClassIdList($id_list)
    {
        $note_histories = NoteUpdateHistory::whereIn('trial_class_id', $id_list)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return $note_histories;
    }
}
