<?php

namespace App\DAO\WebDao;

use App\Models\DaClass;

class ClassDao{
    
    public function fetchAllClassList()
    {
        return DaClass::where('status', 1)->get();
    }
}
