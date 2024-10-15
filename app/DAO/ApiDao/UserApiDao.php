<?php
namespace App\DAO\ApiDao;

use App\Models\User;

class UserApiDao{
    
    public function getTeacherByUserId($user_id) {
       return User::where('id', $user_id)
                ->where('user_type', User::USER_TYPE_TEACHER)
                ->get();
    }
}