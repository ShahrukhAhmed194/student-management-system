<?php

namespace App\DAO\WebDao;

use Illuminate\Support\Facades\DB;

class DaoForReports{

    private function getStudentsMonthlyTerminationReportSQL()
    {
        return "SELECT users.name, 
            DATE(students.admitted_on) AS admitted_on, 
            DATE(students.terminated_on) AS terminated_on, 
            PERIOD_DIFF(
                EXTRACT(YEAR_MONTH FROM students.terminated_on),
                EXTRACT(YEAR_MONTH FROM students.admitted_on)
            ) AS duration
            FROM `students`
            JOIN users 
                ON students.user_id = users.id
            WHERE students.status = 0
            AND DATE(students.terminated_on) BETWEEN ? AND ?
            ORDER BY duration ASC;"
        ;
    }
    public function fetchSalesCountForCSTeam($start_date, $end_date){
        $reports = DB::select("SELECT DATE(admitted_on) as date,
                COUNT(CASE WHEN admitted_by = 7076 THEN 1 END) AS 'Mushfiq',
                COUNT(CASE WHEN admitted_by = 8183 THEN 1 END) AS 'Fahmida',
                COUNT(CASE WHEN admitted_by = 1484 THEN 1 END) AS 'Shammi',
                COUNT(CASE WHEN admitted_by = 5967 THEN 1 END) AS 'Sakil',
                COUNT(CASE WHEN admitted_by = 4872 THEN 1 END) AS 'Mehjabin',
                COUNT(CASE WHEN admitted_by = 6243 THEN 1 END) AS 'Anjon',
                COUNT(CASE WHEN admitted_by = 8102 THEN 1 END) AS 'YSSE'

                FROM students
                WHERE (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1
                GROUP BY DATE(admitted_on)
                ORDER BY admitted_on ASC");
    
        return $reports;
    }

    public function fetchSalesSumForCSTeam($start_date, $end_date){
        $reports = DB::select("SELECT  
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 7076 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as mushfiqTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 8183 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as fahmidaTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 1484 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as shammiTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 5967 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as shakilTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 4872 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as mehjabinTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 6243 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as anjonTotalSale,
                        (SELECT COUNT(id) FROM students WHERE admitted_by = 8102 AND (DATE(admitted_on) BETWEEN '".$start_date."' AND '".$end_date."') AND status = 1) as YSSETotalSale");
        return $reports;
    }

    public function fetchStudentCountOfTeacher($search_params)
    {
        $query = "SELECT c.id, c.name, count(*) as student_count
                FROM students s
                JOIN da_classes c ON c.id = s.class_id
                WHERE c.status = 1 AND s.status = 1";
        
        $params = [];

        if (!is_null($search_params['teacher_id'])) {
            $query .= " AND c.teacher_id = ?";
            $params[] = $search_params['teacher_id'];
        }

        $query .= " GROUP BY c.name ORDER BY student_count";

        $students = DB::select($query, $params);

        return $students;
    }


    public function fetchParentDetailsOfEachTrialClassRegistration($search_params)
    {
        $query = "SELECT id, gurdian_name, phone, email, occupation, gender
            FROM 
                trial_classes
            WHERE 
                status = 'Admitted'
        ";
        $params = [];

        if (!is_null($search_params['start_date']) && !is_null($search_params['end_date'])) {
            $query .= " AND DATE(updated_at) BETWEEN ? AND ?";
            $params = [
                $search_params['start_date'],
                $search_params['end_date']
            ];
        }

        $parents = DB::select($query, $params);

        return $parents;
    }

    public function fetchStudentsMonthlyTerminationReport($start_date, $end_date)
    {
        $query = $this->getStudentsMonthlyTerminationReportSQL();
        $bindings = [$start_date, $end_date];

        return DB::select($query, $bindings);
    }
}
