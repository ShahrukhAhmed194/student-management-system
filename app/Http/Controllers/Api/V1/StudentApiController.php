<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\ApiServices\StudentApiServices;
use App\Services\ApiServices\UtilsApiServices;
use App\DAO\ApiDao\StudentApiDao;

class StudentApiController extends Controller
{
    protected $student_api_services, $utils_api_services;
    protected $student_api_dao;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->student_api_services = new StudentApiServices();
        $this->utils_api_services = new UtilsApiServices ();
        $this->student_api_dao = new StudentApiDao();

    }

    public function studentsClasInfo($student_id){
        $student = $this->student_api_dao->getStudentById($student_id);
        if($student){
            $payload = $this->student_api_services->getStudentClassInfo($student_id);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    public function studentProfile($student_id){
        $student = $this->student_api_dao->getStudentById($student_id);
        if($student){
            $payload = $this->student_api_services->getStudentProfileInfo($student_id);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }

        return response()->json($response);
    }
}
