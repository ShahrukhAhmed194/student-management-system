<?php
namespace App\DAO\ApiDao;

use App\Models\StudentsParent;

class ParentApiDao{
    
    public function getParentByUserId($user_id) {
        return StudentsParent::where('user_id', $user_id)->first();
    }
    
}