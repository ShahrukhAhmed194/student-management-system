<?php
namespace App\Services\WebServices;

use App\DAO\WebDao\{StudentDao, UserDao};
use App\Models\{User};
use App\Traits\messages\SendMessagesToUsers;
use App\Services\WebServices\{StudentServices};

class UserServices{

    use SendMessagesToUsers;
    protected $user_dao, $student_dao, $student_services;

    public function __construct()
    {
        $this->user_dao = new UserDao();
        $this->student_dao = new StudentDao();
        $this->student_services = new StudentServices();
    }
    
    public function getUserListOnStatus($status){
        
        return $this->user_dao->fetchUserListOnStatus($status);
    }

    public function getAllCustomerSupportExecutives()
    {
        return $this->user_dao->getCustomerSupportUser();
    }

    public function getAllTeacher()
    {
        return $this->user_dao->fetchAllTeachers();
    }

    public function getAllUsersButParentStudentAndTeacher()
    {       
        return $this->user_dao->fetchAllUsersButParentStudentAndTeacher();
    }

    public function getAnActiveUserUsingUserName($user_name)
    {
        return $this->user_dao->fetchAnActiveUserUsingUserName($user_name);
    }

    public function getErrorMessageIfUserIsInactiveOrHasDuePayments($user)
    {
        $error_msg = NULL;
        $today = date('Y-m-d');

        if($user->user_type == User::USER_TYPE_PARENT){
            $children = $this->student_dao->fetchChildrenWhosePaymentsAreDueInstallmentsMoreThenOne($user->id, $today);

            if ($children){
                $error_msg = $this->generatePaymentDueMessageForParent($children);
            }
        }else{
            $student = $this->student_dao->fetchStudentByUserId($user->id);

            if($student->status != 1){
                $error_msg = $this->generateErrorMessageForNonAdmittedStudents();

            }else{
                $student = $this->student_dao->fetchStudentWhosePaymentPendingDueInstallmentsMoreThenOne($user->id, $today);

                if($student){
                    $error_msg = $this->generatePaymentDueMessageForStudent($student);
                }
            }
        }

        return $error_msg;
    }
    
}