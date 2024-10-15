<?php

namespace App\DAO\WebDao;

use Illuminate\Support\Facades\DB;

class TrialClassCallHistoriesDao{
    
    private function getTrialClassSalesCallReportSQL()
    {
        return "SELECT date(created_at) as call_date, count(*) as total_calls
            FROM trial_class_call_histories
            WHERE date(created_at) BETWEEN ? AND ?
            AND user_id = ?
            GROUP BY date(created_at);"
        ;
    }

    public function fetchTrialClassSalesCallReport($filters)
    {
        $query = $this->getTrialClassSalesCallReportSQL();
        $bindings = [$filters['start_date'], $filters['end_date'], $filters['user_id']];

        return DB::select($query, $bindings);
    }
}
