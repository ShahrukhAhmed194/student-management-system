<?php

namespace App\DAO\WebDao;

use App\Models\{SalesUser};

class SalesUserDao{
    
    public function fetchAllSalesUserWithUser()
    {
        return SalesUser::with('user')->get();
    }
}
