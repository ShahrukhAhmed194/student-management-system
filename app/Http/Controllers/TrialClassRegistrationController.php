<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrialClassRegistrationRequest;
use App\Jobs\TrialClassRegistration\ProcessSms;
use App\Jobs\TrialClassRegistration\ProcessWhatsAppMessage;
use App\Models\TrialClass;
use App\Models\TrialClassSchedule;
use App\Traits\ApiResponseTrait;
use App\Traits\messages\SendMessagesToUsers;
use App\Traits\WhatsAppNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TrialClassRegistrationController extends Controller
{
    use ApiResponseTrait;
    use WhatsAppNotification, SendMessagesToUsers;
    
    //create
    public function create(Request $request)
    {
        if(count($request->all()) > 0) {
            Log::info('trail-class-registration-request-data', $request->all());
        }
        $ref = $request->ref;
        
        return view('trial_class_registration', compact('ref'));
    }
    
    //store
    public function store(TrialClassRegistrationRequest $request)
    {
        DB::beginTransaction();
        try {
            if (TrialClass::where('email', $request->email)->valid()->count() >= 2) {
                return $this->error("You have already registered for 2 trial classes using - $request->email");
            }
            
            if (TrialClass::where('phone', $request->phone)->valid()->count() >= 2) {
                return $this->error("You have already registered for 2 trial classes using - $request->phone");
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
            
            $trialClass = TrialClass::create($request->validated());
            
            $parents_email = $trialClass->email;
            $date = Carbon::parse($trialClass->schedule->date)->format('jS F');
            $time = date('h:i A', strtotime($trialClass->schedule->time));
            $zoom_link = $trialClass->schedule->teacher->value_a;
            $class_login_details = $trialClass->schedule->teacher->class_login_details;
            
            $trialClass->schedule->decrement('available_seats');
            
            /**
             *  send sms to parent to notify about trial class registration.
             *  paremeter: recevier number, messeage
             */
            
            /*if(config('app.env') === 'production') {
                $smsMessage = view('templates.sms.trial_class_registration', compact('trialClass'));
                ProcessSms::dispatch($request->phone, $smsMessage->render());
            }*/
            
            /**
             *  send whatsapp message to parent to notify about trial class registration.
             *  paremeter: recevier number, messeage
             */
            
            if(config('app.env') === 'production'){
                $whatsAppMessage = view('templates.whats_app.trial_class_registration', compact('trialClass', 'country_shortname', 'support_phone'));
                ProcessWhatsAppMessage::dispatch($request->phone, $whatsAppMessage->render());
            }
            
            /*
             *Send email to instructor for trial class notification
             *parameters : receiver mail, date, time, zoom link.
             */
            $instructorContent = [
                'country' => $country,
                'support_phone' => $support_phone,
                'parents_email' => $trialClass->schedule->teacher->email,
                'date' => $date,
                'time' => $time,
                'zoom_link' => $zoom_link,
                'class_login_details' => $class_login_details
            ];
            
            dispatch(function () use ($trialClass, $instructorContent) {
                Mail::to($trialClass->schedule->teacher->email)
                    ->send(new \App\Mail\NotifyInstructorMailer($instructorContent));
            });
            
            
            /*
             *send email to parent for registration confirmation.
             *paremeters : receiver mail, class date, class time, zoom link
            */
            $parentContent = [
                'country' => $country,
                'support_phone' => $support_phone,
                'parents_email' => $parents_email,
                'date' => $date,
                'time' => $time,
                'value_a' => $zoom_link,
                'age' => $trialClass->age,
                'class_login_details' => $class_login_details
            ];
            
            dispatch(function() use ($parents_email, $parentContent){
                Mail::to($parents_email)
                    ->send(new \App\Mail\NotifyParentMailer( (object) $parentContent));
            });
            
            if(config('app.env') === 'production') {
                dispatch(function () use ($trialClass) {
                    if ($trialClass->schedule->coordinator) {
                        $msg = $this->getMessageForAssignedCustomerSupportExecutiveOfTrialClass($trialClass->id);
                        $this->sendWANotification($trialClass->schedule->coordinator->phone, $msg);
                    }
                });
            }
            
            $url = route('trial.class.registration.success');

            if (app()->isProduction()) {
                $url = 'https://dreamersacademy.com.bd/trial-class-registration/success.html';
            }
            
            DB::commit();
            return $this->redirect('Trail Class Registration completed successfully', $url);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }
    
    public function getTrialClassRegistrationDate(Request $request)
    {
        $query = TrialClassSchedule::where('age_from', '<=', $request->age)
            ->where('age_to', '>=', $request->age);
        if($request->country == 'India'){
            $query = $query->where('country', 'India');
            
        }elseif($request->country == 'United Kingdom'){
            $query = $query->where('country', 'United Kingdom');
            
        }else{
            $query = $query->where('country', 'Bangladesh');
        }
        return $query->where('date', '>', now()->toDateString())
            ->where('status', 1)
            ->where('available_seats', '>', 0)
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();
    }
    
    public function getTrialClassRegistrationTime(Request $request)
    {
        if ($request->date) {
            $query = TrialClassSchedule::where('date', $request->date)
                ->where('age_from', '<=', $request->age)
                ->where('age_to', '>=', $request->age);
            if($request->country == 'India'){
                $query->where('country', 'India');
            }elseif($request->country == 'United Kingdom'){
                $query->where('country', 'United Kingdom');
            }else{
                $query->where('country', 'Bangladesh');
            }
            return $query->where('status', 1)
                ->where('available_seats', '>', 0)->get();
        }
    }
    
    //success
    public function success()
    {
        return view('trial_class_registration_success');
    }
    
    
}
