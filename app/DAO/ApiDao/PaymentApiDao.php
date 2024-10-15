<?php
namespace App\DAO\ApiDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;

class PaymentApiDao{
    
    
    public function saveOrUpdatePayment(Request $request){
        $months = json_encode($request->for_month);
       $payment = Payment::updateOrInsert(
            // ['transaction_id'=> $request->transaction_id],
            ['student_id' => $request->student_id,
            'fees' => $request->amount,
            'currency' => (($request->transaction_type == 'stripe') ? 'USD' : 'BDT'),
            'transaction_purpose' => $request->purpose,
            'notes' => $request->notes,
            'agreement' => $request->agreement,
            'installment' => $request->installment,
            'invoice_id' => $request->invoice_id,
            'payment_status' => 'Completed',
            'for_month' => $months,
            'invoice_sent' => false,
            'transaction_type' => $request->transaction_type,
            'transaction_id' => $request->transaction_id,
            'invoice_id' => $request->invoice_id,
            'bkash_response' =>$request->bkash_response,
            'created_at' => date('Y-m-d H:m:i'),
            'updated_at' => date('Y-m-d H:m:i'),
            ]
        )->get();
        
        return $payment;
    }

    
    public function updateStudentAfterPayment(Request $request){
        $student = Student::where('id', $request->student_id)->first();
        $student->due_installments -= $request->installment;
        if($student->due_installments <= 0){
            $student->payment_status = "Paid";
        }
        $student->save();

        return $student;
    }

    public function getChildrenPaymentHistory($parent_user_id)
    {
        $payment_histories = DB::select("SELECT users.name, payments.id as payment_id, payments.student_id, payments.fees, payments.currency, payments.date, payments.invoice_id, payments.for_month, payments.payment_status
                             FROM payments 
                             JOIN students on (students.id = payments.student_id)
                             JOIN users on (users.id = students.user_id)
                             WHERE students.parent_id = ".$parent_user_id);

        return $payment_histories;
    }
}