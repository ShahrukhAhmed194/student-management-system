<?php
namespace App\Traits;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;

trait PaymentService{
    
    public function saveOrUpdatePayment(Request $request){
        $send_confirmation = (($request->send_confirmation != null) ? 1 : 0);
        $invalidStatus = ($request->invalid == 'invalid') ? '0' : '1';
        $months = json_encode($request->for_month);
       $payment = Payment::updateOrInsert(
            ['transaction_id'=> $request->transaction_id],
            ['student_id' => $request->student_id,
            'fees' => $request->fees,
            'currency' => (($request->transaction_type == 'stripe') ? 'USD' : 'BDT'),
            'date' => $request->date,
            'transaction_type' => $request->transaction_type,
            'transaction_purpose' => $request->transaction_purpose,
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
            'agreement' => $request->agreement,
            'installment' => $request->installment,
            'invoice_id' => $request->invoice_id,
            'payment_status' => 'Completed',
            'send_confirmation' => $send_confirmation,
            'status' => $invalidStatus,
            'for_month' => $months,
            'invoice_sent' => false,
            'created_at' => date('Y-m-d H:m:i'),
            'updated_at' => date('Y-m-d H:m:i'),
            ]
        )->get();
        
        return $payment;
    }

    public function saveOrUpdateBkashPayment(Request $request){
        $send_confirmation = (($request->send_confirmation != null) ? 1 : 0);
        $invalidStatus = ($request->invalid == 'invalid') ? '0' : '1';
        $months = json_encode(explode(',', $request->for_month));
       $payment = Payment::updateOrInsert(
            ['transaction_id'=> $request->transaction_id],
            ['student_id' => $request->student_id,
            'fees' => $request->fees,
            'currency' => (($request->transaction_type == 'stripe') ? 'USD' : 'BDT'),
            'date' => $request->date,
            'transaction_type' => $request->transaction_type,
            'transaction_purpose' => $request->transaction_purpose,
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
            'agreement' => $request->agreement,
            'installment' => $request->installment,
            'invoice_id' => $request->invoice_id,
            'payment_status' => 'Completed',
            'send_confirmation' => $send_confirmation,
            'status' => $invalidStatus,
            'for_month' => $months,
            'invoice_sent' => false,
            'created_at' => date('Y-m-d H:m:i'),
            'updated_at' => date('Y-m-d H:m:i'),
            ]
        );
        
        return $payment;
    }

    public function updateStudentAfterPayment(Request $request){
        $student = Student::where('id', $request->student_id)->first();
        if($request->enable_installment == 'on'){
            if(is_null($student->due_installments)){
                $student->due_installments = 0;
            }else{
                $student->due_installments -= $request->installment;
                if(!is_null($student->due_for_months)){
                    $due_for_months = explode(',' , $student->due_for_months);
                    $iteration = $request->installment;
                    while($iteration > 0){
                        array_shift($due_for_months);
                        $iteration -- ;
                    }
                    $student->due_for_months = implode("," , $due_for_months);
                }
            }
        }
        if($student->due_installments <= 0){
            $student->payment_status = "Paid";
        }
        $student->save();

        return $student;
    }

    public function updateStudentAfterBkashPayment(Request $request){
        $student = Student::where('id', $request->student_id)->first();
        $student->due_installments = $student->due_installments - $request->installment;
        if($student->due_installments <= 0){
            $student->payment_status = "Paid";
        }
        $student->save();

        return $student;
    }

    public function saveBkashResponse(Request $request)
    {
        $payment = Payment::updateOrInsert(
            ['transaction_id'=> $request->transaction_id],
            ['bkash_response' => $request->bkash_response]
        );
        return $payment;
    }
}