<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiServices\ClassApiServices;
use App\Services\ApiServices\UtilsApiServices;
use App\DAO\ApiDao\StudentApiDao;

class ClassApiController extends Controller
{
    protected $class_api_services, $utils_api_services;
    protected $student_api_dao;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->class_api_services = new ClassApiServices();
        $this->utils_api_services = new UtilsApiServices();
        $this->student_api_dao = new StudentApiDao();
    }

    public function getTrackInformation($id){
        if($id == 1){
            $track = $this->class_api_services->getTrackOneDetails();
        }elseif($id == 2){
            $track = $this->class_api_services->getTracktwoDetails();
        }elseif($id == 3){
            $track = $this->class_api_services->getTrackThreeDetails();
        }else{
            $track = NULL;
        }

        if($track){
            $response = $this->utils_api_services->getOkResponse($track);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    public function getStudentClassDetails($user_id){
        $student = $this->student_api_dao->getStudentByUserId($user_id);
        if($student){
            $payload = $this->class_api_services->getClassDetails($user_id);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }
}
