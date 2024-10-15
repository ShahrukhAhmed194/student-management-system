<?php

namespace App\DAO\WebDao;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentDao{
    
    private function getStudentsMonthlyReportSQL()
    {
        return "SELECT month,
                SUM(admitted_count) AS admitted_count,
                SUM(graduated_count) AS graduated_count,
                SUM(on_hold_count) AS on_hold_count,
                SUM(deleted_count) AS deleted_count,
                SUM(terminated_count) AS terminated_count
            FROM (
                SELECT 
                    DATE_FORMAT(created_at, '%M, %Y') AS month,
                    CASE WHEN status = 1 AND DATE(created_at) BETWEEN ? AND ? THEN 1 ELSE 0 END AS admitted_count,
                    0 AS graduated_count,
                    0 AS on_hold_count,
                    0 AS deleted_count,
                    0 AS terminated_count
                FROM students
                WHERE DATE(created_at) BETWEEN ? AND ?

                UNION ALL

                SELECT 
                    DATE_FORMAT(graduated_on, '%M, %Y') AS month,
                    0 AS admitted_count,
                    CASE WHEN status = 2 AND DATE(graduated_on) BETWEEN ? AND ? THEN 1 ELSE 0 END AS graduated_count,
                    0 AS on_hold_count,
                    0 AS deleted_count,
                    0 AS terminated_count
                FROM students
                WHERE DATE(graduated_on) BETWEEN ? AND ?

                UNION ALL

                SELECT 
                    DATE_FORMAT(on_hold_since, '%M, %Y') AS month,
                    0 AS admitted_count,
                    0 AS graduated_count,
                    CASE WHEN status = 3 AND DATE(on_hold_since) BETWEEN ? AND ? THEN 1 ELSE 0 END AS on_hold_count,
                    0 AS deleted_count,
                    0 AS terminated_count
                FROM students
                WHERE DATE(on_hold_since) BETWEEN ? AND ?

                UNION ALL

                SELECT 
                    DATE_FORMAT(deleted_on, '%M, %Y') AS month,
                    0 AS admitted_count,
                    0 AS graduated_count,
                    0 AS on_hold_count,
                    CASE WHEN status = 4 AND DATE(deleted_on) BETWEEN ? AND ? THEN 1 ELSE 0 END AS deleted_count,
                    0 AS terminated_count
                FROM students
                WHERE DATE(deleted_on) BETWEEN ? AND ?

                UNION ALL

                SELECT 
                    DATE_FORMAT(terminated_on, '%M, %Y') AS month,
                    0 AS admitted_count,
                    0 AS graduated_count,
                    0 AS on_hold_count,
                    0 AS deleted_count,
                    CASE WHEN status = 0 AND DATE(terminated_on) BETWEEN ? AND ? THEN 1 ELSE 0 END AS terminated_count
                FROM students
                WHERE DATE(terminated_on) BETWEEN ? AND ?
            ) AS counts
            GROUP BY month
            ORDER BY STR_TO_DATE(month, '%M, %Y');"
        ;
    }

    private function getStudentsTrialClassPayableDetailsReportSQL()
    {
        return "SELECT payable_amount, count(*) as total_students
            FROM students
            where date(admitted_on) between ? and ?
            and admitted_by = ?
            group by payable_amount
            order by payable_amount;"
        ;
    }
    
    private function getStudentWhosePaymentPendingANdDueInstallmentsMoreThenOneSQL()
    {
        return "SELECT users.id, users.user_type, users.name, users.email, students.due_for_months, students.payable_amount, students.due_installments, students.status
            FROM students
            JOIN users ON students.user_id = users.id
            WHERE students.payment_status = 'Pending' 
            AND students.due_grace = 0
            AND students.due_installments > 1 
            AND students.due_date <= ?"
        ;
    }

    public function fetchStudentByID($id)
    {
        return Student::find($id);
    }

    public function fetchActiveStudentsList($filter)
    {        
        $students = DB::select("SELECT s.id, s.student_id, us.name as student_name, u.name as parent_name, p.phone, dc.name as class_name,
           u.email, s.class_id, s.due_installments, s.due_for_months, s.gender, s.class_start_date, s.no_of_classes, s.due_date, s.status,
           s.active_payment, s.payable_amount, s.payment_status, s.admitted_on, s.terminated_on, s.students_note, coo.name coordinatorName
		FROM students s
		LEFT JOIN users us ON (us.id = s.user_id)
		LEFT JOIN parents p ON (p.user_id = s.parent_id)
		LEFT JOIN users u ON (u.id = p.user_id)
        LEFT JOIN da_classes dc ON (dc.id = s.class_id)
        LEFT JOIN users coo ON (coo.id = dc.coordinator_id)
		WHERE s.id != 0 AND s.status = 1 AND s.payment_status IS NOT NULL
        AND (? IS NULL OR s.due_installments = ?)
        AND (? IS NULL OR us.email LIKE ?)
        AND (? IS NULL OR s.due_date >= ?)
        AND (? IS NULL OR s.due_date <= ?)
        AND (? IS NULL OR s.due_date IS NULL)
        AND (? IS NULL OR p.phone LIKE ?)
        AND (? IS NULL OR
            (CASE
                WHEN ? = 'student_not_assigned' THEN s.class_id = 1
                WHEN ? = 'advanced_payment' THEN s.payment_status = 'Paid' AND s.due_installments <= 0 AND (due_for_months  != '' AND due_for_months IS NOT NULL)
                WHEN ? = 'wrong_payment' THEN s.payment_status = 'Paid' AND ((due_for_months  = '' OR due_for_months IS NULL) OR (s.due_installments > 1 OR s.due_installments IS NULL))
                WHEN ? = 'month_due' THEN s.payment_status = 'Pending' AND
                    (CASE
                        WHEN ? = 3 THEN s.due_installments >= ?
                        ELSE s.due_installments = ?
                    END)
                WHEN ? = 'wrong_due' THEN s.payment_status = 'Pending' AND (s.due_installments = 0 OR s.due_installments < 0 OR s.due_installments IS NULL)
                WHEN ? = 'non_advanced_payment' THEN s.payment_status = 'Paid' AND s.due_installments = 1 AND (due_for_months  != '' AND due_for_months IS NOT NULL)
            END)
         )
		;",
        [
            $filter['due_installments'], $filter['due_installments'], $filter['email'], '%'.$filter['email'].'%',
            $filter['start_date'], $filter['start_date'], $filter['end_date'], $filter['end_date'],
            $filter['due_date'], $filter['phone'],  '%'.$filter['phone'].'%',
            $filter['filter'], $filter['filter'], $filter['filter'], $filter['filter'], $filter['filter'],
            $filter['month'], $filter['month'], $filter['month'], $filter['filter'], $filter['filter']
        ]);

        return $students;
    }

    public function fetchStudentsMonthlyReport($start_date, $end_date)
    {
        $query = $this->getStudentsMonthlyReportSQL();
        $bindings = $bindings = [
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date,
            $start_date, $end_date
        ];

        return DB::select($query, $bindings);
    }

    public function fetchStudentsTrialClassPayableDetailsReport($filters)
    {
        $query = $this->getStudentsTrialClassPayableDetailsReportSQL();
        $bindings = [$filters['start_date'], $filters['end_date'], $filters['user_id']];

        return DB::select($query, $bindings);
    }
    
    public function fetchStudentWhosePaymentPendingDueInstallmentsMoreThenOne($student_user_id, $today)
    {
        $query = $this->getStudentWhosePaymentPendingANdDueInstallmentsMoreThenOneSQL();
        $query .= " AND students.user_id = ?;";
        $bindings = [$today, $student_user_id];

        return DB::select($query, $bindings);
    }

    public function fetchChildrenWhosePaymentsAreDueInstallmentsMoreThenOne($parent_id, $today)
    {
        $query = $this->getStudentWhosePaymentPendingANdDueInstallmentsMoreThenOneSQL();
        $query .= " AND students.parent_id = ?;";
        $bindings = [$today, $parent_id];

        return DB::select($query, $bindings);
    }

    public function fetchStudentByUserId($user_id)
    {
        return Student::select('id', 'status')->where('user_id', $user_id)->first();
    }

    public function fetchDueReport()
    {
        return DB::select("SELECT s.student_id, c.name, s.due_date, s.due_installments 
            FROM students s
            join da_classes c on (c.id = s.class_id) 
            where s.status = 1 and payment_status = 'Pending' 
            order by c.name;")
        ;
    }
}