<?php
namespace App\Services\ApiServices;

use App\Models\Student;

class PaymentApiServices{
    
    public function getStudentPaymentHistory($user_id){
        $payload = array();

        $payments = Student::join('payments', 'payments.student_id', 'students.user_id')
                   ->join('users', 'users.id', 'students.user_id')
                   ->where('students.user_id', $user_id)
                   ->get();
        if($payments && $payments != '[]'){
            foreach($payments as $index => $payment){
                $reformed_data[$index] = [
                    "invoice_id" => $payment->invoice_id,
                    "student_name" => $payment->name,
                    "amount" => $payment->fees,
                    "for_month" => $payment->for_month,
                    "status"  => $payment->status
                ];
            }
            $payload = array(
                "payment" => $reformed_data
            );
        }
        return $payload;
    }
    
    public function getStudentPayableData($studentInfo){
        $payload = array();

        $payload = array(
            "student_id" => $studentInfo->id,
            "amount" => $studentInfo->payable_amount,
            "installment" => $studentInfo->due_installments,
            'purpose' => 'monthly-fee',
            'for_month' => date('F'),
            'notes' => '',
            'agreement' => 1
        );
        return $payload;
    }
}