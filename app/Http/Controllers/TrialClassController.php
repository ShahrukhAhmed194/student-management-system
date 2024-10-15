<?php

namespace App\Http\Controllers;

use App\DAO\ApiDao\TrialClassApiDao;
use App\DAO\WebDao\UserDao;
use App\Models\{DaClass,
    LeadLogInfo,
    NewLead,
    NoteUpdateHistory,
    SalesUser,
    StatusActionHistory,
    Student,
    StudentsParent,
    TrialClass,
    TrialClassCallHistory,
    TrialClassSchedule,
    User};
use App\Services\WebServices\{SalesUserServices, TrialClassNoteUpdateHistoryServices, TrialClassServices};
use App\Traits\{NotifyParent, SendMessage, Utils, WhatsAppNotification};
use App\Traits\trialClass\UpdateTrialClass;
use App\Traits\validators\TrialClassValidators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Mail};


class TrialClassController extends Controller
{
    use NotifyParent, SendMessage, WhatsAppNotification, TrialClassValidators, UpdateTrialClass, Utils;

    protected $trialClassApiDao, $trial_Class_services, $sales_user_services, $trial_Class_note_serevices;
    public $user;
    private $userDao;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
        $this->trialClassApiDao = new TrialClassApiDao();
        $this->trial_Class_services = new TrialClassServices();
        $this->sales_user_services = new SalesUserServices();
        $this->trial_Class_note_serevices = new TrialClassNoteUpdateHistoryServices();
        
        $this->userDao = new UserDao();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('trial_class.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any trial class!');
        }

        $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
        $customerSupportExecutives = $this->userDao->getCustomerSupportUser();
        $parametersData = $this->trial_Class_services->getParameterDatas($request = NULL, 'index');
        $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
        $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
        $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);
        
        return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'customerSupportExecutives'));
    }
    public function myWorkList()
    {
        if (is_null($this->user) || !$this->user->can('trial_class.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any trial class!');
        }
        $request = request();
        $request->merge(['sales_user_id' => Auth::user()->id,]);
        $parametersData = $this->trial_Class_services->getParameterDatas($request, 'index');
        $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
        $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
        $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
        $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);
        $customerSupportExecutives = $this->userDao->getCustomerSupportUser();
        
        return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'customerSupportExecutives'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrialClass  $trialClass
     * @return \Illuminate\Http\Response
     */
    public function show(TrialClass $trialClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrialClass  $trialClass
     * @return \Illuminate\Http\Response
     */
    public function edit(TrialClass $trialClass)
    {
        if (is_null($this->user) || !$this->user->can('trial_class.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any trial class!');
        }
        $action_histories = StatusActionHistory::where('trial_class_id', $trialClass->id)
                        ->orderBy('date', 'DESC')
                        ->get();
        $note_histories = NoteUpdateHistory::where('trial_class_id', $trialClass->id)
                        ->orderBy('created_at', 'DESC')
                        ->get();
        $callHistory = TrialClassCallHistory::where('trial_class_id', $trialClass->id)
                        ->orderBy('id', 'DESC')
                        ->get();
        $coordinators = User::where('user_type', User::USER_TYPE_COORDINATOR)->get();
        
        $getSalesUsers = SalesUser::with('user')->get();
        $loggedInSalesUserId = Auth::user()->id;

        $param = $_GET['backlink'];
        
        return view('trial-class.edit', [
            'trial_class' => $trialClass,
            'action_histories' => $action_histories,
            'note_histories' => $note_histories,
            'callHistory' => $callHistory,
            'param' => $param,
            'getSalesUsers' => $getSalesUsers,
            'loggedInSalesUserId' => $loggedInSalesUserId,
            'coordinators' => $coordinators,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrialClass  $trialClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrialClass $trialClass)
    {
        if(!is_null($request->note)){
            $this->saveNoteHistory($request);
            $request->request->remove('note');
        }
        
        if($request->schedule){
            $this->updateRescheduledClassSeatNumber($request->schedule);
            $request->merge(['trial_class_id' =>$request->schedule]);
            $request->request->remove('schedule');
        }
        if($request->prev_status != $request->status){
            $this->saveActionHistory($request->status, $trialClass->id);
        }

        $country = $request->country;
        $support_phone = $country_shortname = '';
        if($country == 'United Kingdom'){
            $support_phone = "+447405976999";
            $country_shortname = "UK";
        }elseif($country == 'Bangladesh'){
            $support_phone = "+8801897-717780, +8801897-717781";
            $country_shortname = "Bangladesh";
        }
        
        $this->trialClassApiDao->trialClassStatusUpdate($request);

        if ($request->status == 'Rescheduled') {
            //$userInfo = user::find($request->teacher_id);
		$trialClassScheduleInfo = TrialClassSchedule::find($request->trial_class_id);
		//dd($trialClassScheduleInfo);
            $newDateTime = $trialClassScheduleInfo->date .' '. $trialClassScheduleInfo->time;
	    
	    $userInfo = user::find($trialClassScheduleInfo->teacher_id);
	    $zoom_link = $userInfo->value_a;
            $class_login_details = $userInfo->class_login_details;

            /**
         *  send sms to parent to notify about trial class registration.
         *  paremeter: recevier number, messeage
         */
            $sms_msg = "[Dreamers] কোডিং ক্লাসে রেজিষ্ট্রেশন সফল হয়েছে। ক্লাসের সময়: $newDateTime, জুম লিংক: $zoom_link, ক্লাস লগিন ডিটেইলস: $class_login_details";

        //if(config('app.env') === 'production'){
            $this->SMSNotification($request->phone, $sms_msg);
        //}
            
        /**
         *  send whatsapp message to parent to notify about trial class registration.
         *  paremeter: recevier number, messeage
         */
        $age = $request->age;
       
        $whatapp_greeting = "Greetings from Dreamers Academy

Dear $request->gurdian_name,
                         
Your child's ($request->student_name) Coding for Kids trial class is scheduled for $trialClassScheduleInfo->date at ".date('h:i A', strtotime($newDateTime))."(Bangladesh Standard Time).

Here is the class details to join:
Link: $zoom_link
Class Login Details: $class_login_details";
        
        $whatsapp_note = "

Note: You must join from a PC and require an internet connection. Please check your microphone, speaker and video camera 5 minutes before the class for a better experience. We will record the class for quality purposes.

For any queries, please feel free to contact us at:
+8801897-717780, +8801897-717781";

        $whatapp_msg = $whatapp_greeting . $whatsapp_note;
        if(config('app.env') === 'production'){
            $this->sendWANotificationSecond($request->phone, $whatapp_msg);
        }

         /*
         *send email to parent for registration confirmation.
         *paremeters : receiver mail, class date, class time, zoom link
        */
          $parentContent = [
            'support_phone' => $support_phone,
            'country' => $country,
            'parents_email' => $request->email,
            'date' => $trialClassScheduleInfo->date,
            'time' => $trialClassScheduleInfo->time,
            'value_a' => $zoom_link,
            'age' => $age,
            'class_login_details' => $class_login_details
        ];
   
        Mail::to($request->email)
            ->send(new \App\Mail\NotifyParentMailer((object) $parentContent));
    }

        if ($request->status == 'Admitted' && $request->prev_status != 'Admitted') {
            $validator = $this->validatePayableAmmount($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Create Parent
            $user = new User();
            $user->name = $request->gurdian_name;
            $user->user_name = $request->email;
            $user->email = $request->email;
            $unhashed_pass = 'Dreamers';
            $user->password = Hash::make($unhashed_pass);
            $user->user_type = User::USER_TYPE_PARENT;
            $user->save();

            $user->assignRole($user->user_type);

            $parent = new StudentsParent();
            $parent->user_id = $user->id;
            $parent->gender = 'Male';
            $parent->phone = $request->phone;
            $parent->address = 'address';
            $parent->save();

            // Create Student
            $user2 = new User();
            $user2->name = $request->student_name;
            $user2->user_name = 'DA' . random_int(10000000, 99999999);
            $user2->email = $request->email;
            $unhashed_pass2 = 'Dreamers';
            $user2->password = Hash::make($unhashed_pass2);
            $user2->user_type = User::USER_TYPE_STUDENT;
            $user2->save();
            
            $user2->assignRole($user2->user_type);

            $student = new Student();
            $student->student_id = $user2->user_name;
            $student->user_id = $user2->id;
            $student->class_id = DaClass::where('id', '!=', 0)->first()->id;
            $student->parent_id = $user->id;
            $student->school = $request->school;
            $student->age = $request->age;
            $student->gender = $request->gender;
            $student->status = 1;
            $student->payable_amount = $request->payable_amount;
            $student->payment_status = 'Pending';
            $student->active_payment = 1;
            $student->admitted_on = now();
            $student->admitted_by = auth()->user()->id; //(!empty($request->sales_user_id) ? $request->sales_user_id : '');
            $student->save();

            /**
             *  send whatsapp message to parent to notify about login details.
             *  paremeter: recevier number, messeage
             */
            $whatapp_msg = "*[ALERT] Account Details | Dreamers App*\n\n*The following is parent's account details:*\nName:  ".$user->name."\nUser Name:  ".$user->user_name."\nPassword:  ".$unhashed_pass."\nApp Link:  https://dreamers.lead.academy/login\n\n*The following is child's account details:*\nName:  ".$user2->name."\nUser Name:  ".$user2->user_name."\nPassword:  ".$unhashed_pass2."\nApp Link: https://dreamers.lead.academy/login\Regards,\n*Team Dreamers*.";
            $this->sendWANotificationSecond($parent->phone, $whatapp_msg);
            /* 
            *Send email to parent with login details
            *parameters : receiver mail, content of data.
            */
            $contentData = [
                'subject' => '[ALERT] Account Details | Dreamers App',
                'parent_name' => $user->name,
                'parent_user_name' => $user->user_name,
                'parent_password' => $unhashed_pass,
                'child_name' => $user2->name,
                'child_user_name' => $user2->user_name,
                'child_password' => $unhashed_pass2
            ];
            Mail::to($user->email)->send(new \App\Mail\AdmissionConfirmationMailer($contentData));

            // Insert into lead db 
            NewLead::create([
                'student_id' => $student->student_id,
                'name' => $user2->name,
                'mobile' => $request->phone,
                'email' => $request->email,
                'address' => '',
                'biography' => '',
                'country' => $request->country,
                'city' => '',
                'state' => 'dhaka',
                'zipcode' => '1230',
                'enterprise_id' => '1',
                'status' => '1',
                'created_by' => '2',
                'updated_by' => '2',
            ]);
            // Insert into loginfo table
            LeadLogInfo::create([
                'log_id' => $student->student_id,
                'name' => $request->student_name,
                'shortname' => 'shortname',
                'mobile' => $request->phone,
                'email' => $user2->email,
                'user_types' => '4',
                'is_admin' => '4',
                'ip_address' => '::1',
                'status' => '1',
                'enterprise_id' => '1',
                'created_by' => '2',
                'updated_by' => '2'
            ]);
        }

        $request->request->remove('prev_status');
        $trialClass->update($request->all());
        
        toastr()->success('Trial class updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrialClass  $trialClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrialClass $trialClass)
    {
        //
    }

    public function searchByDateGet(Request $request){

        $parametersData = $this->trial_Class_services->getParameterDatas($request, 'search');

        if($this->trial_Class_services->checkIfAllTheParametersAreEmpty($parametersData)){

            return redirect()->back()->with('error','Your Search Credintials Are Wrong. Please Provide "Schedule Date", "Applied Date", "Status" Or "Country" Properly Before Searching.');
        }else{

            $loggedInSalesUserId = Auth::user()->id;
            $getSalesUsers = $this->sales_user_services->getAllSalesUserWithUser();
            $trial_classes = $this->trial_Class_services->getFilteredTrialClassListAfterSearch($parametersData);
            $id_list = $this->trial_Class_services->getTrialClassIdList($trial_classes);
            $note_histories = $this->trial_Class_note_serevices->getNotesByTrialClassIdList($id_list);
            $customerSupportExecutives = $this->userDao->getCustomerSupportUser();

            return view('trial-class.index', compact('trial_classes', 'note_histories', 'parametersData', 'getSalesUsers', 'loggedInSalesUserId', 'customerSupportExecutives'));
        }
    }

    public function attendanceTracking($id){
        if (!can('attendance.add')) {
            return abort(403, unauthorized());
        }
    
        $trial_class_students = TrialClass::where('trial_class_id', $id)
        ->where('status','!=', 'Invalid')
        ->where('status','!=', 'Wants to Reschedule')
        ->get();

        if($trial_class_students == null || $id == 0){
            return redirect('error');
        } else{
            return view('teacher.trial-class.attendance',[
                'trial_classes' => $trial_class_students
            ]);
        }
    }

    public function setAttendance(Request $request){
        $getSalesUsers = SalesUser::with('user')->where('available', 1)->get();
        
        $countgetSalesUsers = count($getSalesUsers);
        $index = 0;
        $count = count($request['ids']);
        $presentIndex = 0;
        while($index<$count){
            $trial_class = TrialClass::find($request['ids'][$index]);
            // ------------------- its for sales team trial class attendance data provided --------------------
            $salesTeamMobile = $track = $scheduleAt = $link = $salesTeamUserId = '';
            
            if(!empty($request['status'][$index]) && $countgetSalesUsers > 0){
                $teamIndex = ($presentIndex)%$countgetSalesUsers;
                $salesTeamMobile = $getSalesUsers[$teamIndex]->mobile;
                $salesTeamUserId = $getSalesUsers[$teamIndex]->user_id;
                $hasDevice = ($trial_class->hasDevice == 1) ? 'Yes' : 'No';
                $trialClassTeacherName = $trial_class->schedule->teacher->name;
                if($trial_class->age == 7 || $trial_class->age == 8){
                    $track = "Track-1";
                }elseif($trial_class->age == 9 || $trial_class->age == 10){
                    $track = "Track-2";
                }else{
                    $track = "Track-3";
                }
                $scheduleAt = date('d M, Y', strtotime($trial_class->schedule->date)) ." *at* " .date('h:i A', strtotime($trial_class->schedule->time));
                $link = url("/trial-class/".$trial_class->id."/edit/?backlink=http%3A%2F%2F127.0.0.1%3A8000%2Fshow-trial-class-students-today");

                $salesTeamWhatsappMessage = "

*[TRIAL CLASS ALERT]*

$trial_class->id
From : $trial_class->country
Contact : $trial_class->phone
Email : $trial_class->email
Instructor : $trialClassTeacherName ( $track )
Has Device: $hasDevice
Scheduled at: $scheduleAt
Link : $link";
                /**
                 *  send whatsapp message to parent to notify about trial class registration.
                 *  paremeter: recevier number, messeage
                 */
                if(config('app.env') === 'production'){
                    if($trial_class->sales_user_id == NULL || $trial_class->sales_user_id == 0){
                        $this->sendWANotification($salesTeamMobile, $salesTeamWhatsappMessage);
                    }
                }
                $presentIndex++;
            }

            // ------------------------ close ----------------------
            $trial_class->feed_back = $request['feed_back'][$index];
            if($trial_class->sales_user_id == NULL || $trial_class->sales_user_id == 0){
                $trial_class->sales_user_id = (!empty($salesTeamUserId) ? $salesTeamUserId : NULL);
            }
            if(!empty($request['is_joined'][$index]) && $request['is_joined'][$index] == 'Joined' && empty($request['status'][$index])){
                $trial_class->status = 'Joined';
            }else{
                $trial_class->status = empty($request['status'][$index]) ? 'Absent' : 'Attended';
            }
            $this->saveActionHistory($trial_class->status, $trial_class->id);
            $trial_class->save();

            // it is for SMS, WA & Email Send start
                $parentEmail = $trial_class->email;
                $parentPhone = $trial_class->phone;
                $parentName = $trial_class->gurdian_name;
                $student_name = $trial_class->student_name;
            if(empty($request['status'][$index])){
                $sms_msg = "[Dreamers] আপনার সন্তান : (".$student_name.") আজকের কোডিং ট্রায়াল ক্লাসে অনুপস্থিত ছিল। যত তাড়াতাড়ি সম্ভব আমাদের সাথে যোগাযোগ করুন।";
                $whatapp_msg = "আপনার সন্তান : (".$student_name.") আজকের কোডিং ট্রায়াল ক্লাসে অনুপস্থিত ছিল। যত তাড়াতাড়ি সম্ভব আমাদের সাথে যোগাযোগ করুন।";
                $email_msg = "Your child: (".$student_name.") was absent in today's Coding trial class. Please contact us as soon as possible.
                Phone Numbers: +8801897-717780, +8801897-717781";
                

            }else{
                $sms_msg = "[Dreamers] আপনার সন্তান : (".$student_name.") কোডিং ট্রায়াল ক্লাস শেষ করেছে। আমরা যত তাড়াতাড়ি সম্ভব ভর্তি প্রক্রিয়া সম্পর্কে আপনার সাথে যোগাযোগ করব।";
                $whatapp_msg = "আপনার সন্তান : (".$student_name.") কোডিং ট্রায়াল ক্লাস শেষ করেছে। আমরা যত তাড়াতাড়ি সম্ভব ভর্তি প্রক্রিয়া সম্পর্কে আপনার সাথে যোগাযোগ করব।";
                $email_msg = "Your child: (".$student_name.") Coding trial class has completed. We will contact you regarding the admission process as soon as possible.";
            }

                /**
                 *  send sms to parent to notify about trial class registration.
                 *  paremeter: recevier number, messeage
                 */
                if(config('app.env') === 'production'){
                   // $this->sendWANotificationSecond($parentPhone, $sms_msg);
                }
                /**
                 *  send whatsapp message to parent to notify about trial class registration.
                 *  paremeter: recevier number, messeage
                 */
                if(config('app.env') === 'production'){
                    //$this->sendWANotificationSecond($parentPhone, $whatapp_msg);
                }

                 /* 
                 *Send email to instructor for trial class notification
                 *parameters : receiver mail, date, time, zoom link.
                 */
                 $contentData = [
                            'subject' => 'Coding Class Attendance Alert',
                            'parentName' => $parentName,
                            'email_msg' => $email_msg,
                        ];
                //Mail::to($parentEmail)->send(new \App\Mail\NotifyPresentAbsentMailer($contentData)); 
            // it is for SMS, WA & Email Send close
            $index++;
        } 
        toastr()->success('Attendance Saved.');

        return redirect('trial-class/attendance/'.$request->link_id);
    }

    public function getTrialClassSchedules(Request $request){
        $dates = DB::select("select * 
                from trial_class_schedules 
                WHERE age_from <= " . $request->age .
                " and age_to >= " . $request->age .
                " and date >= CURDATE() 
                and country = '" . $request->country . "'" .
                " and status = 1
                and available_seats > 0");

        return $dates;
    }

    public function trialclassStudentNameEmailPhoneCheck(Request $request){
        $status = $request->status;
        if($status == 'Admitted'){
            $checkAdmittedStudent = TrialClass::where('student_name', $request->student_name)
                                ->where('email', $request->email)
                                ->where('phone', $request->phone)
                                ->where('age', $request->age)
                                ->where('gender', $request->gender)
                                ->where('status', 'Admitted')
                                ->get();
            if(count($checkAdmittedStudent) > 0){
                echo 'alreadyAdmitted';
            }else{
                echo 'no';
            }
        }
    }

    public function validateRegistrationStepByStep(Request $request)
    {
        if($request->index == 1){
            $validator = $this->validateFirstFieldset($request);
        }elseif($request->index == 2){
            $validator = $this->validateSecondFieldset($request);
        }elseif($request->index == 3){
            $validator = $this->validateThirdFieldset($request);
        }else{
            return 'Success';
        }
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            return 'Success';
        }
    }

    public function saveTrialClassCallHistory(Request $request){
        $user_id = $request->user_id;
        $trial_class_id = $request->trial_class_id;
        $phone = $request->phone;
        
        TrialClassCallHistory::create([
            'trial_class_id' => $trial_class_id,
            'user_id' => $user_id,
            'phone' => $phone,
        ]);

        return true;
    }

}
