<?php
namespace App\DAO\WebDao;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDao
{
    private function getAllUsersButParentStudentAndTeacherSQL()
    {
        return "SELECT `id`, `name`
            FROM `users`
            WHERE `status` = 1
            AND `user_type` NOT IN (?, ?, ?)"
        ;
    }

    public function getCustomerSupportUser(){

        return User::where('user_type', User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE)->select('id', 'name')->get();
    }

    public function fetchUserListOnStatus($status){
        $users = User::where('status', $status)
                ->whereNotIn('user_type', [User::USER_TYPE_PARENT, User::USER_TYPE_STUDENT])
                ->get();

        return $users;
    }

    public function fetchAllTeachers()
    {
        $teachers = User::where('user_type', User::USER_TYPE_TEACHER)
                ->select('id', 'name')
                ->get();

        return $teachers;
    }

    public function fetchAllUsersButParentStudentAndTeacher()
    {
        $query = $this->getAllUsersButParentStudentAndTeacherSQL();
        $bindings = [User::USER_TYPE_PARENT, User::USER_TYPE_STUDENT, User::USER_TYPE_TEACHER];

        return DB::select($query, $bindings);
    }
    
    public function fetchAnActiveUserUsingUserName($user_name)
    {
        return User::where('user_name', $user_name)
               ->where('status', 1)
               ->first();
    }
}