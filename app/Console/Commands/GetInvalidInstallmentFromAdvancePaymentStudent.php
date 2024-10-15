<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class GetInvalidInstallmentFromAdvancePaymentStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-invalid-installment-from-advance-payment-student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get invalid installment students from advance payment student list.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = Student::with('latestPayment')->paymentPaid()->admitted()
            ->where('due_installments', '<=', 0)
            ->select('id', 'student_id', 'due_installments', 'due_for_months', 'payment_status')->latest()->get();
        
        $csrStudent = $students->filter(function ($student) {
            return $student->due_installments  == '-99' && $student->due_for_months  == "NA";
        });
        
        $invalidPaymentStudents = $students->filter(function ($student) {
            return $student->latestPayment  == null && $student->due_for_months  != "NA";
        })
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'student_id' => $student->student_id,
                    'due_installments' => $student->due_installments,
                    'due_for_months' => $student->due_for_months,
                    'payment_status' => $student->payment_status,
                    'payments' => $student->payments
                ];
            })
        ;
        
        
        $remainingStudents = $students->reject(function ($student) {
            return ($student->due_installments  == '-99' && $student->due_for_months  == "NA") || ($student->latestPayment  == null && $student->due_for_months  != "NA");
        });
        
        $remainingStudents = $remainingStudents->map(function ($student) {
            $currentMonth = date('F');
            $currentMonthIndex = date('n');
            
            $futureMonthsCount = 0;
            $hasFutureMonth = false;
            $hasCurrentMonth = false;
            $hasPastMonth = false;
            
            $forMonths = json_decode($student->latestPayment->for_month);
            
            foreach ($forMonths as $month) {
                $monthIndex = date('n', strtotime($month));
                
                if ($monthIndex > $currentMonthIndex) {
                    $hasFutureMonth = true;
                    $futureMonthsCount--;
                } elseif ($monthIndex < $currentMonthIndex) {
                    $hasPastMonth = true;
                } elseif ($month == $currentMonth) {
                    $hasCurrentMonth = true;
                }
                
            }
            
            if ($hasPastMonth && !$hasCurrentMonth && !$hasFutureMonth) {
                $futureMonthsCount = null;
            }
            $student->expected_installment = $futureMonthsCount;
            return $student;
        });
        
        $invalidPaymentStudentData = [];
        
        foreach ($invalidPaymentStudents as $student) {
            $invalidPaymentStudentData[] = [
                'id' => $student['id'],
                'student_id' => $student['student_id'],
                'due_installments' => $student['due_installments'],
                'expected_installment' => "N/A",
                'payment_status' => $student['payment_status'],
                'expected_payment_status' => "N/A",
            ];
        }
        
        $studentData = [];
        
        foreach ($remainingStudents as $student) {
            $studentData[] = [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'due_installments' => $student->due_installments,
                'expected_installment' => $student->expected_installment,
                'payment_status' => $student->payment_status,
                'expected_payment_status' => $student->expected_installment == null ? 'Pending' : 'Paid',
            ];
        }
        
        $this->info('Invalid Payment Students');
        $this->info(collect($invalidPaymentStudentData));
        $this->info('Student Data');
        $this->info(collect($studentData));
    }
}
