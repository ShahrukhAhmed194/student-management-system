<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\PaymentDao;

class PaymentServices{

    protected $payment_dao;

    public function __construct()
    {
        $this->payment_dao = new PaymentDao();

    }

    public function getPaymentHistoryOfStudent($id)
    {
        return $this->payment_dao->fetchPaymentHistoryOfStudent($id);

    }
}
