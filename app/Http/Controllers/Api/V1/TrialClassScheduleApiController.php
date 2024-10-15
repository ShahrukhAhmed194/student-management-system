<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiServices\TrialClassScheduleApiServices;
use App\Services\ApiServices\UtilsApiServices;
use Illuminate\Http\Request;

class TrialClassScheduleApiController extends Controller
{

    protected $trial_class_schedule_api_services, $utils_api_services;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->trial_class_schedule_api_services = new TrialClassScheduleApiServices();
        $this->utils_api_services = new UtilsApiServices();

    }
    
    public function trialClassScheduleDates(Request $request){
        if($request->age > 6 && $request->age < 15){
            $payload = $this->trial_class_schedule_api_services->fetchTrialClassScheduleDates($request);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    public function trialClassScheduleTimes(Request $request){
        if($request->age > 6 && $request->age < 17){
            $payload = $this->trial_class_schedule_api_services->fetchTrialClassScheduleTimes($request);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }
}
