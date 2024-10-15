<?php

namespace App\DAO\WebDao;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrialClassDao{

    private function getTrialClassQuery()
    {
        return "SELECT trial_classes.phone, trial_classes.email, trial_class_schedules.date, trial_class_schedules.time, users.value_a, users.class_login_details
            FROM 
                trial_classes
            JOIN 
                trial_class_schedules ON trial_class_schedules.id = trial_classes.trial_class_id
            JOIN 
                users ON trial_class_schedules.teacher_id = users.id
            WHERE
                trial_class_schedules.status = 1 AND trial_classes.status != 'Invalid'
            AND
                trial_class_schedules.date = ?";
    }

    private function getUTMMediumSQL()
    {
        return "SELECT utm_medium, COUNT(*) as total
            FROM trial_classes 
            WHERE utm_medium IS NOT NULL
            AND status != 'Invalid'
            AND date(created_at) BETWEEN ? AND ?
            GROUP BY utm_medium
            ORDER BY total DESC";
    }

    public function fetchFilteredTrialClassListAfterSearch($parametersData, $status)
    {
        $bindings = [];

        $query = "SELECT tc.*, s.date, s.time, su.name as sales_user, coo.name as coordinator, teacher.name as teacher_name, DATE_ADD(tc.created_at, INTERVAL 6 HOUR) as createdAt
            FROM 
                trial_classes tc
            JOIN 
                trial_class_schedules s ON (s.id = tc.trial_class_id)
            LEFT JOIN 
                users su ON (su.id = tc.sales_user_id)
            LEFT JOIN 
                users coo on (coo.id = s.coordinator_id)
            LEFT JOIN 
                users teacher on (teacher.id = s.teacher_id)
            WHERE 
                tc.status != 'Invalid' AND tc.trial_class_id != '0'";

            if ($parametersData['from'] == 'day') { //checks if user is coming from dashboard count

                $query .= " AND (? IS NULL OR s.date = ?) GROUP BY tc.email";
                $bindings = [$parametersData['day'], $parametersData['day']];

            } else{

                $query .= " AND (? IS NULL OR tc.id = ?)
                    AND (? IS NULL OR tc.student_name LIKE ?)
                    AND (? IS NULL OR tc.email LIKE ?)
                    AND (? IS NULL OR tc.phone LIKE ?)
                    AND (? IS NULL OR s.time = ?)
                    AND (? IS NULL OR tc.age >= ?)
                    AND (? IS NULL OR tc.age <= ?)
                    AND ((? IS NULL OR ? IS NULL) OR s.date BETWEEN ? AND ?)
                    AND ((? IS NULL OR ? IS NULL) OR DATE(tc.created_at) BETWEEN ? AND ?)
                    AND (? IS NULL OR tc.country = ?)
                    AND (? IS NULL OR tc.sales_user_id = ?)
                    AND (? IS NULL OR s.coordinator_id = ?)
                    AND (? IS NULL OR tc.hasDevice = ?)"
                ;
                $bindings = [
                    $parametersData['trial_id'], $parametersData['trial_id'], 
                    $parametersData['studentName'], '%' . $parametersData['studentName'] . '%',
                    $parametersData['email'], '%' . $parametersData['email'] . '%',
                    $parametersData['phone'], '%' . $parametersData['phone'] . '%',
                    $parametersData['time'], $parametersData['time'],
                    $parametersData['from_age'], $parametersData['from_age'],
                    $parametersData['to_age'], $parametersData['to_age'],
                    $parametersData['from_date'], $parametersData['to_date'], 
                    $parametersData['from_date'], $parametersData['to_date'],
                    $parametersData['applied_from_date'], $parametersData['applied_to_date'], 
                    $parametersData['applied_from_date'], $parametersData['applied_to_date'],
                    $parametersData['country'], $parametersData['country'],
                    $parametersData['sales_user_id'], $parametersData['sales_user_id'],
                    $parametersData['coordinator_id'], $parametersData['coordinator_id'],
                    $parametersData['hasDevice'], $parametersData['hasDevice'],
                ];
            }
        
        if ($status !== null) {

            $query .= " AND tc.status IN ($status)";
        }

        $query .= " ORDER BY tc.created_at DESC";

        if($parametersData['from'] == 'index'){ //if the user in trial class index page then data fetch is limited to 100

            $query .= " Limit 100";
        }

        $trial_classes = DB::select($query, $bindings);

        return $trial_classes;
    }

    public function fetchParentsWhoseChildHasTrialClassToday()
    {
        $query = $this->getTrialClassQuery();
        $bindings = [ Carbon::today()->toDateString()];

        return DB::select($query, $bindings);
    }
    
    public function fetchParentsWhoseChildHasTrialClassTomorrow()
    {
        $query = $this->getTrialClassQuery();
        $bindings = [Carbon::tomorrow()->toDateString()];

        return DB::select($query, $bindings);
    }

    public function fetchTrialClassDailyReport($start_date, $end_date)
    {
       $query = "SELECT date(created_at) AS date, COUNT(id) AS TOT,
                SUM(CASE WHEN status = 'Registered' THEN 1 ELSE 0 END) AS REG,
                SUM(CASE WHEN status = 'Attended' THEN 1 ELSE 0 END) AS ATT,
                SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS ABS,
                SUM(CASE WHEN status = 'Wants to Reschedule' THEN 1 ELSE 0 END) AS WTR,
                SUM(CASE WHEN status = 'Not Reachable' THEN 1 ELSE 0 END) AS NOR,
                SUM(CASE WHEN status = 'Will Attend' THEN 1 ELSE 0 END) AS WAT,
                SUM(CASE WHEN status = 'Rescheduled' THEN 1 ELSE 0 END) AS RES,
                SUM(CASE WHEN status = 'Admitted' THEN 1 ELSE 0 END) AS ADM,
                SUM(CASE WHEN status = 'Will Admit Later' THEN 1 ELSE 0 END) AS WAL,
                SUM(CASE WHEN status = 'Payment Pending' THEN 1 ELSE 0 END) AS PAP,
                SUM(CASE WHEN status = 'Decision Pending' THEN 1 ELSE 0 END) AS DEP,
                SUM(CASE WHEN status = 'Refused Admission' THEN 1 ELSE 0 END) AS REF,
                SUM(CASE WHEN status = 'Not Interested' THEN 1 ELSE 0 END) AS NOI,
                SUM(CASE WHEN status = 'Invalid' THEN 1 ELSE 0 END) AS INV
            FROM trial_classes
            WHERE date(created_at) BETWEEN ? AND ?
            GROUP BY date(created_at)
            ORDER BY date(created_at) ASC;";

        $bindings = [$start_date, $end_date];

        return DB::select($query, $bindings);
    }

    public function fetchUpcommingTrialClassReport()
    {
        return DB::select("SELECT date AS Date, dayname(date) AS Day, COUNT(*) AS Schedules
            FROM trial_class_schedules
            WHERE status = 1 AND date > CURDATE()
            GROUP BY date
            ORDER BY date ASC;
        ");
    }

    public function fetchCSWiseTrialClassStatusReport()
    {
        return DB::select("SELECT u.name,
                SUM(CASE WHEN tc.status = 'Registered' THEN 1 ELSE 0 END) AS REG,
                SUM(CASE WHEN tc.status = 'Absent' THEN 1 ELSE 0 END) AS ABS,
                SUM(CASE WHEN tc.status = 'Wants to Reschedule' THEN 1 ELSE 0 END) AS WTR,
                SUM(CASE WHEN tc.status = 'Not Reachable' THEN 1 ELSE 0 END) AS NOR,
                SUM(CASE WHEN tc.status = 'Will Attend' THEN 1 ELSE 0 END) AS WAT,
                SUM(CASE WHEN tc.status = 'Rescheduled' THEN 1 ELSE 0 END) AS RES,
                SUM(CASE WHEN tc.status = 'Not Interested' THEN 1 ELSE 0 END) AS NOI
            FROM trial_class_schedules ts
            join trial_classes tc on (ts.id = tc.trial_class_id)
            join users u on (u.id = ts.coordinator_id)
            where ts.coordinator_id is not null and ts.coordinator_id != 1
            and ts.status = 1
            group by u.name;
        ");
    }

    public function fetchUTMMediumReport($filters)
    {
        $query = $this->getUTMMediumSQL();
        $bindings = [$filters['start_date'], $filters['end_date']];

        return DB::select($query, $bindings);
    }

    public function fetchIntroCallCSReport()
    {
        return DB::select("SELECT t.id, u.name,
                DATE_FORMAT(CONVERT_TZ(t.created_at, '+00:00', '+06:00'), '%h:%i %p') AS 'registered',
                DATE_FORMAT(CONVERT_TZ(MIN(h.created_at), '+00:00', '+06:00'), '%h:%i %p') AS 'intro_call',
                TIMESTAMPDIFF(MINUTE, CONVERT_TZ(t.created_at, '+00:00', '+06:00'), CONVERT_TZ(MIN(h.created_at), '+00:00', '+06:00')) AS 'diff'
            FROM
                trial_classes t
            JOIN
                trial_class_schedules s ON s.id = t.trial_class_id
            JOIN
                users u ON u.id = s.coordinator_id
            JOIN
                trial_class_call_histories h ON h.trial_class_id = t.id AND h.user_id = s.coordinator_id
            WHERE
                DATE(t.created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                AND t.status != 'Invalid'
            group by t.id
            ORDER BY u.name;"
        );
    }

}