<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{BkashDao};
use Illuminate\Support\Facades\Crypt;

class BkashServices{

    protected $bkash_dao;

    public function __construct()
    {
        $this->bkash_dao = new BkashDao();
    }

    public function getBkashPaymentInfoWithChild($request)
    {
        $bkash_id = Crypt::decryptString($request->bkash_id);
        $bkashes = $this->bkash_dao->fetchBkashPaymentInfoWithChild($bkash_id);
        $notes = ($bkashes[0]->transactionReference ? 'Reference : ' . $bkashes[0]->transactionReference . PHP_EOL : '') . $bkashes[0]->debitMSISDN;
        
        if(count($bkashes) == 1 && $bkashes[0]->student_id){
            $response = [
                'student_id' => $bkashes[0]?->student_id,
                'due_for_months' => $bkashes[0]?->due_for_months,
                'due_installments' => $bkashes[0]?->due_installments,
                'fees' => $bkashes[0]?->amount,
                'transaction_type' => 'bkash',
                'transaction_id' => $bkashes[0]?->trxID,
                'notes' =>  $notes,
                'date' => date('Y-m-d', strtotime($bkashes[0]?->created_at))
            ];
        }else{
            $response = [
                'fees' => $bkashes[0]?->amount,
                'transaction_type' => 'bkash',
                'transaction_id' => $bkashes[0]?->trxID,
                'notes' =>  $notes,
                'date' => date('Y-m-d', strtotime($bkashes[0]?->created_at))
            ];
        }
        

        return response()->json($response);
    }

    public function updateBkashTransactionPaymentID($payment_id, $transaction_id)
    {
        return $this->bkash_dao->setBkashTransactionTablePaymentID($payment_id, $transaction_id);
    }
}
