<?php
namespace App\DAO\ApiDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentsParent;
use App\Models\DaClass;
use App\Models\TrialClass;
use App\Models\StudentTrialTimeline;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Traits\Utils;

class TrialClassApiDao{

    use Utils;

	public function trialClassRegistration($request){
        
        $currentTimestamp = time();
        $currentTime = date('H:i', $currentTimestamp);

		$gurdian_name = $request->parent_name;
        $phone = $request->phone_number;
        $email = $request->email;
        $occupation = $request->profession;
        $hasDevice = $request->has_computer;
        $hasDevice = ($hasDevice == 'Yes' ? '1' : 0);
        $language = $request->language;
        
        $student_name = $request->student_name;
        $school = $request->school;
        $gender = $request->gender;
        $age = $request->age;
        $trial_class_id = $request->trial_schedule_id;
        $unhashed_pass = 'DA-'.$this->getUniqueId(5);
        $hashPassword = Hash::make($unhashed_pass);
        
		$trialClass = TrialClass::create([
            'trial_class_id' => $trial_class_id,
            'gurdian_name' => $gurdian_name,
            'phone' => $phone,
            'email' => $email,
            'occupation' => $occupation,
            'hasDevice' => $hasDevice,
            'language' => $language,
            'student_name' => $student_name,
            'school' => $school,
            'gender' => $gender,
            'age' => $age,
        ]);

        
        // Create Parent
        $user = User::updateOrCreate(
            [
               'email' => $email, 
               'user_type' => User::USER_TYPE_PARENT
            ],
            [
                'name' => $gurdian_name,
                'user_name' => $email,
                'email' => $email,
                'password' => $hashPassword,
                'user_type' => User::USER_TYPE_PARENT,
            ],
        );

        
        // ============= its for parent login =================
        $token = '';
        $token = Auth::login($user);
        // =================parent login close ================
        
        $roleId = 4;
        $roles = Role::find($roleId);

        $user->assignRole($roles);

        $parent = new StudentsParent();
        $parent->user_id = $user->id;
        $parent->gender = 'Male';
        $parent->phone = $phone;
        $parent->address = 'address';
        $parent->save();

        // Create Student
        $user2 = new User();
        $user2->name = $student_name;
        $user2->user_name = 'DA' . random_int(10000000, 99999999);
        $user2->email = $email;
        $unhashed_pass2 = 'DA-'.$this->getUniqueId(5);
        $user2->password = Hash::make($unhashed_pass2);
        $user2->user_type = User::USER_TYPE_STUDENT;
        $user2->save();

        $student = new Student();
        $student->student_id = $user2->user_name;
        $student->user_id = $user2->id;
        $student->class_id = DaClass::where('id', '!=', 0)->first()->id;
        $student->parent_id = $user->id;
        $student->trial_class_id = $trialClass->id;
        $student->school = $school;
        $student->age = $age;
        $student->gender = $gender;
        $student->status = -1;
        $student->payable_amount = '';
        $student->payment_status = '';
        $student->active_payment = 0;
        $student->admitted_on = now();
        $student->save();

        $studentTrialTimeLine = StudentTrialTimeline::create([
            'student_id' => $student->id,
            'trial_class_id' => $trialClass->id,
            'registration_complete' => 1,
            'registration_complete_date' => date('Y-m-d'),
            'registration_complete_time' => (!empty($currentTime) ? $currentTime : ''),
        ]);
        // --------------- close -------------

        $allResults = array(
            'trialClassData' => $trialClass,
            'parent_user_id' => $user->id,
            'student_user_id' => $user2->id,
            'status' => $student->status,
            'authorization' => [
                'user_name' => (!empty($email) ? $email : ''),
                'password' => (!empty($unhashed_pass) ? $unhashed_pass : ''),
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 6000000000000
            ]
        );
		return $allResults;
    }

    public function trialClassStatusUpdate($request){
        $currentTimestamp = time();
        $currentTime = date('H:i', $currentTimestamp);

        $trialClassId = $request->action_id;
        $status = $request->status;
        $getTrialClassStudent = Student::where('trial_class_id', $trialClassId)->first();
        
        if($getTrialClassStudent){
            $studentId = $getTrialClassStudent->id;
            $trialClassId = $getTrialClassStudent->trial_class_id;
            
            $will_attend = $will_attend_date = $will_attend_time = $rescheduled = $rescheduled_date = 
            $rescheduled_time = $attended = $attended_date = $attended_time = $refused_admission = 
            $refused_admission_date = $refused_admission_time = '';

            if($status == 'Will Attend'){
                $will_attend = 1;
                $will_attend_date = date('Y-m-d');
                $will_attend_time = $currentTime;
                
                StudentTrialTimeline::where("student_id", $studentId)
                ->where('trial_class_id', $trialClassId)
                ->update([
                    'will_attend' => $will_attend,
                    'will_attend_date' => $will_attend_date,
                    'will_attend_time' => $will_attend_time,
                ]);
            }elseif($status == 'Rescheduled'){
                $rescheduled = 1;
                $rescheduled_date = date('Y-m-d');
                $rescheduled_time = $currentTime;
                
                StudentTrialTimeline::where("student_id", $studentId)
                ->where('trial_class_id', $trialClassId)
                ->update([
                    'rescheduled' => $rescheduled,
                    'rescheduled_date' => $rescheduled_date,
                    'rescheduled_time' => $rescheduled_time,
                ]);
            }elseif($status == 'Attended'){
                $attended = 1;
                $attended_date = date('Y-m-d');
                $attended_time = $currentTime;
                
                StudentTrialTimeline::where("student_id", $studentId)
                ->where('trial_class_id', $trialClassId)
                ->update([
                    'attended' => $attended,
                    'attended_date' => $attended_date,
                    'attended_time' => $attended_time,
                ]);
            }elseif($status == 'Refused Admission'){
                $refused_admission = 1;
                $refused_admission_date = date('Y-m-d');
                $refused_admission_time = $currentTime;
                
                StudentTrialTimeline::where("student_id", $studentId)
                ->where('trial_class_id', $trialClassId)
                ->update([
                    'refused_admission' => $refused_admission,
                    'refused_admission_date' => $refused_admission_date,
                    'refused_admission_time' => $refused_admission_time,
                ]);
            }
        }
        return true;
    }
}