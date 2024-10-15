<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{ClassDao};

class ClassServices{

    protected $class_dao;
    public function __construct()
    {
        $this->class_dao = new ClassDao();
    }

    public function getAllClassList()
    {
        return $this->class_dao->fetchAllClassList();
    }
}
