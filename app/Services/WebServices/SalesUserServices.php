<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{SalesUserDao};

class SalesUserServices{

    protected $sales_user_dao;

    public function __construct()
    {
        $this->sales_user_dao = new SalesUserDao();
    }

    public function getAllSalesUserWithUser()
    {
        return $this->sales_user_dao->fetchAllSalesUserWithUser();
    }
}
