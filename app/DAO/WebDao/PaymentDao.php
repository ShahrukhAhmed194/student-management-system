<?php

namespace App\DAO\WebDao;

use App\Models\{Payment};

class PaymentDao{
    
    public function fetchPaymentHistoryOfStudent($id)
    {
        $payments = Payment::join('students', 'students.id', 'payments.student_id')
                                ->where('students.id', $id)
                                ->where('payments.status', 1)
                                ->orderBy('payments.date', 'desc')
                                ->get();
        return $payments;
    }
}
