<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\TrialClass;
use App\Models\StudentsParent;
use App\Models\TrialClassSchedule;
use App\Traits\Api\Validators\ApiValidator;
use App\Traits\WhatsAppNotification;
use App\Traits\SendMessage;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use App\Services\ApiServices\TrialClassApiServices;
use App\Services\ApiServices\UtilsApiServices;
use App\Services\ApiServices\StudentApiServices;
use App\DAO\ApiDao\TrialClassApiDao;
use App\DAO\ApiDao\ParentApiDao;
use App\DAO\ApiDao\UserApiDao;
use App\DAO\ApiDao\StudentApiDao;

class TrialClassApiController extends Controller
{

    // use ApiValidator, TrialClassApiService, SendMessage, WhatsAppNotification;
    use ApiValidator, SendMessage, WhatsAppNotification;

    //service objects
    protected $trial_class_api_services, $student_api_services, $utils_api_services;
    //DAO objects
    protected $trialClassApiDao, $user_api_dao, $student_api_dao, $parent_api_dao;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->trial_class_api_services = new TrialClassApiServices();
        $this->utils_api_services = new UtilsApiServices();
        $this->student_api_services = new StudentApiServices();
        $this->trialClassApiDao = new TrialClassApiDao();
        $this->user_api_dao = new UserApiDao();
        $this->student_api_dao = new StudentApiDao();
        $this->parent_api_dao = new ParentApiDao();
    }

    public function registration(Request $request){ 
        $country = $country_shortname = 'Bangladesh';
        $support_phone = '+8801897-717781';
        

        $validator = $this->trialClassRegistrationValidate($request);

        if ($validator->fails()) {
            $response = array(
                'status' => false,
                'message' => $validator->errors(),
            );
            return response()->json($response, 422);
        }

        $trialClass = $this->trialClassApiDao->trialClassRegistration($request);
        
        if($trialClass['trialClassData']){
            $scheduleInfo = TrialClassSchedule::with('teacher')->where('id', $trialClass['trialClassData']->trial_class_id)->first();
            
            // --------------- whatsapp message send --------------
            $age = $trialClass['trialClassData']->age;
            $date = Carbon::parse($trialClass['trialClassData']->schedule->date)->format('jS F');
            $time = date('h:i A', strtotime($trialClass['trialClassData']->schedule->time));
            $zoom_link = @$scheduleInfo->teacher->value_a;
            $class_login_details = $trialClass['trialClassData']->schedule->teacher->class_login_details;

            $sms_msg = "[Dreamers] কোডিং ক্লাসে রেজিষ্ট্রেশন সফল হয়েছে। ক্লাসের তারিখ: $date, সময়: $time, জুম লিংক: $zoom_link, ক্লাস লগিন ডিটেইলস: $class_login_details";

            $gurdian_name = $trialClass['trialClassData']->gurdian_name;
            $student_name = $trialClass['trialClassData']->student_name;

            $age_conditional_msg = '';
        if($age == 7 || $age == 8){ 
        $age_conditional_msg = "

You have to install the ScratchJr app before the trial class. Installation links are as follows:
Android : https://play.google.com/store/apps/details?id=org.scratchjr.android
Laptop/desktop : https://jfo8000.github.io/ScratchJr-Desktop/
iPad : https://apps.apple.com/us/app/scratchjr/id895485086
iPhone : https://scratchjr.en.softonic.com/iphone";
        }

            $whatapp_greeting = "Greetings from Dreamers Academy

Dear $gurdian_name,
                            
Your child's ($student_name) Coding for Kids trial class is scheduled for $scheduleInfo->date at ".date('h:i A', strtotime($scheduleInfo->time))."($country_shortname Standard Time).

Here is the class details to join:
Link: $zoom_link
Class Login Details: $class_login_details";
        $whatapp_agemsg = $age_conditional_msg;
        
        $whatsapp_note = "

Note: You must join from a PC and require an internet connection. Please check your microphone, speaker and video camera 5 minutes before the class for a better experience. We will record the class for quality purposes.

For any queries, please feel free to contact us at:
$support_phone";

        $whatapp_msg = $whatapp_greeting .$whatapp_agemsg  .$whatsapp_note;
          /**
         *  send sms to parent to notify about trial class registration.
         *  paremeter: recevier number, messeage
         */
        if(config('app.env') === 'production' && $country == "Bangladesh"){
            $this->SMSNotification($trialClass['trialClassData']->phone, $sms_msg);
        }
        /**
         *  send whatsapp message to parent to notify about trial class registration.
         *  paremeter: recevier number, messeage
         */
        if(config('app.env') === 'production'){
            $this->sendWANotificationSecond($trialClass['trialClassData']->phone, $whatapp_msg);
        }

         /*
         *send email to parent for registration confirmation.
         *paremeters : receiver mail, class date, class time, zoom link
        */
        $parentContent = [
            'country' => $country,
            'support_phone' => $support_phone,
            'parents_email' => $trialClass['trialClassData']->email,
            'password' => $trialClass['authorization']['password'],
            'date' => $date,
            'time' => $time,
            'value_a' => $zoom_link,
            'age' => $age,
            'class_login_details' => $class_login_details
        ];
   
        Mail::to($trialClass['trialClassData']->email)
            ->send(new \App\Mail\NotifyParentMailer((object) $parentContent));

            $payloadData = array();
            $payloadData = array(
                "parent_user_id" => $trialClass['parent_user_id'], 
                "parent_name" => $gurdian_name, 
                "student_user_id" => $trialClass['student_user_id'], 
                "student_name" => $trialClass['trialClassData']->student_name,
                "status" => $trialClass['status'],
                "authorization" => $trialClass['authorization'],
            );
            
            if($trialClass['trialClassData']){
                $response = $this->utils_api_services->getOkResponse($payloadData);
            }else{
                $response = $this->utils_api_services->getNotFoundResponse();
            }
            
            return response()->json($response);
        }
    }

    
    public function parent($user_id){
        $parent = $this->parent_api_dao->getParentByUserId($user_id);

        if($parent && $parent != '[]'){
            $payload = $this->trial_class_api_services->getParentInfo($parent);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return response()->json($response);
    }

    public function upcomingTrialClasses(){
        $payload = $this->trial_class_api_services->fetchUpcomingTrialClasses();
        $response = $this->utils_api_services->getOkResponse($payload);
    
        return response()->json($response);
    }

    public function showTrialClassDetails($user_id){
        $teacher = $this->user_api_dao->getTeacherByUserId($user_id);
        return $teacher;
        if($teacher && $teacher != '[]'){
            $payload = $this->trial_class_api_services->fetchTrialClassDetails($user_id);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return response()->json($response);
    }

    public function studentTrialClassInfo($student_id){
        $getStudentInfo = $this->student_api_dao->getStudentById($student_id);
        if($getStudentInfo && $getStudentInfo != '[]'){
            if($getStudentInfo->status == '-1'){
                $payload = $this->student_api_services->getStudentTrialTimeline($student_id);
            }else{
                $payload = array();
            }
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return response()->json($response);
    }
}