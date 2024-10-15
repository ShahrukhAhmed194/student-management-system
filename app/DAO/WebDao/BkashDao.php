<?php

namespace App\DAO\WebDao;

use Illuminate\Support\Facades\DB;

class BkashDao{

    private function getBkashPaymentInfoWithChildSQL()
    {
        return "SELECT 
            p.id AS parent_id, p.phone, 
            s.id AS student_id, s.due_for_months, s.due_installments,
            b.trxID, 
            b.transactionStatus, 
            b.transactionReference,
            b.debitMSISDN, 
            b.amount,
            b.created_at,
            b.response
            FROM 
                bkashes AS b 
            LEFT JOIN
                parents AS p
                ON b.debitMSISDN = p.phone
            LEFT JOIN 
                students AS s 
                ON p.user_id = s.parent_id
            WHERE 
                b.id = ?"
        ;
    }

    private function getBkashTransactionPaymentIDUpdateSQL()
    {
        return 'UPDATE bkashes SET payment_id = ? WHERE trxID = ?';
    }

    public function fetchBkashPaymentInfoWithChild($bkash_id)
    {
        $sql = $this->getBkashPaymentInfoWithChildSQL();
        $bindings = [$bkash_id];

        return  DB::select($sql, $bindings);
    }

    public function setBkashTransactionTablePaymentID($payment_id, $transaction_id)
    {
        $sql = $this->getBkashTransactionPaymentIDUpdateSQL();
        $bindings = [$payment_id, $transaction_id];

        return DB::update($sql, $bindings);
    }
}