<?php

namespace App\DAO\WebDao;

use Illuminate\Support\Facades\DB;

class ClassRecordingDao{
    
    private function getRecordingMappingMissiongReportSQL()
    {
        return "SELECT d.name as 'class_name', date(a.created_at) as 'class_date', a.uuid
            FROM temp_session_records a
            LEFT JOIN start_class_sessions b ON b.uuid = a.uuid
            LEFT JOIN class_sessions c ON c.id = b.class_session_id
            LEFT JOIN da_classes d ON d.id  = c.class_id
            WHERE Date(a.created_at) BETWEEN ? AND ?
            AND a.is_delete = 0
            ORDER BY date(a.created_at), d.name"
        ;
    }

    public function fetchRecordingMappingMissingReport($filters)
    {
        $query = $this->getRecordingMappingMissiongReportSQL();
        $bindings = [ $filters['start_date'], $filters['end_date'] ];

        return DB::select($query, $bindings);
    }
}
