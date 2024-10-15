<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\DAO\ApiDao\StudentApiDao;
use App\Services\ApiServices\UtilsApiServices;


class HomeApiController extends Controller
{
    
    protected $student_api_dao, $utils_api_services;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->utils_api_services = new UtilsApiServices();
        $this->student_api_dao = new StudentApiDao();
    }

    public function home()
    {
        $response = [
            "status" => 200,
            "message" => "Data Found",
            "payload" => [
                "track" => [
                    [
                        "background_image" => "https://da.com.bd/track-1.png",
                        "title" => "Little Programmer",
                        "track" => 1,
                        "age" => "7 to 8 yrs"
                    ],
                    [
                        "background_image" => "https://da.com.bd/track-2.png",
                        "title" => "Junior Programmer",
                        "track" => 2,
                        "age" => "9 to 10 yrs"
                    ],
                    [
                        "background_image" => "https://da.com.bd/track-3.png",
                        "title" => "Programmer",
                        "track" => 3,
                        "age" => "9 to 14 yrs"
                    ]
                ],
                "pricing" => [
                    [
                        "title" => "Starter",
                        "amount" => "৳0.00",
                        "points" => [
                            "1 FREE Trial Class",
                            "1 Live Class",
                            "Maximum 10 students",
                            "No Admission Fees",
                            "No Recording Provided"
                        ]
                    ],
                    [
                        "title" => "Group",
                        "amount" => "৳1600",
                        "points" => [
                            "1 FREE Trial Class",
                            "2 Weekly Live Classes",
                            "Maximum 10 students",
                            "No Admission Fees",
                            "Class Recording Provided"
                        ]
                    ],
                    [
                        "title" => "One-on-One",
                        "amount" => "৳5000",
                        "points" => [
                            "1 FREE Trial Class",
                            "2 Weekly Live Classes",
                            "1:1 Sessions",
                            "No Admission Fees",
                            "Class Recording Provided"
                        ]
                    ]
                ],
                "testimonial" => [
                    [
                        "link" => "https://youtu.be/wddFqQrI_1k"
                    ],
                    [
                        "link" => "https://youtu.be/oz0RE6o9d9E"
                    ],
                    [
                        "link" => "https://youtu.be/Tbe4Epx5LGM"
                    ]
                ]
            ]
        ];

        return response()->json($response);
    }

    
    public function parentDashboard($user_id){
        $students = $this->student_api_dao->getChildByParentUserId($user_id);
        $payload = array();
        if($students){
            $i = 0;
            foreach($students as $single){
                $payload[$i]['student_id'] = (!empty($single->id) ? $single->id : -1);
                $payload[$i]['student_user_id'] = (!empty($single->user_id) ? $single->user_id : -1);
                $payload[$i]['student_age'] = (!empty($single->age) ? $single->age : -1);
                $payload[$i]['student_name'] = (!empty($single->user->name) ? $single->user->name : '');
                $payload[$i]['picture'] = 'https://da.com.bd/track-1.png';
                $payload[$i]['status'] = ($single->status == 1 ? 1 : -1);
                $i++;
            }
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

}
