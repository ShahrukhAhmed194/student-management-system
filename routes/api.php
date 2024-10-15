<?php

use App\Http\Controllers\Api\MailController;
use App\Mail\{PaymentConfirmation, TrialClassConfirmation};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Route};
use App\Http\Controllers\Api\V1\{AuthController, BkashApiController, ClassApiController, HomeApiController, NotificationApiController, PaymentApiController, StudentApiController, TrialClassApiController, TrialClassScheduleApiController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mail confirmation Api
Route::group(['middleware' => ['auth:sanctum']], function () {
    // api token= jyNUvQR6lbPcY64iFlPR9QKnZIplHNu0e6YMCeNa

    // Generic Mail 
    // Post request: from, to, subject, body
    Route::post('mail/send', [MailController::class, 'generic_mail']);

    // Trial class confirmation mail
    Route::post('trial-class-confirmation', function (Request $request) {
        $trialClassData = [
            'date' => $request->date,
            'time' => $request->time,
            'zoom_link' => $request->zoom_link
        ];
        $trialClass = json_decode(json_encode($trialClassData), FALSE);

        Mail::to($request->email)->send(new TrialClassConfirmation($trialClass));

        return 'Mail send successfully.';
    });
});

// Payment confirmation mail api
Route::group(['middleware' => ['auth:sanctum']], function () {
    // api token= jyNUvQR6lbPcY64iFlPR9QKnZIplHNu0e6YMCeNa

    Route::post('payment-confirmation', function (Request $request) {
        $payment_data = [
            'id' => $request->id,
            'child' => $request->child,
            'invoice_url' => "https://dreamers.lead.academy/payment/$request->id/invoice"
        ];
        $payment = json_decode(json_encode($payment_data), FALSE);

        Mail::to($request->email)->send(new PaymentConfirmation($payment));

        return 'Mail send successfully.';
    });
});


Route::group(['middleware' => 'api', 'prefix' => 'v1/'], function($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('reset-pass-step-email', [AuthController::class, 'reset_pass_step_email']);
    Route::post('reset-pass-step-new', [AuthController::class, 'reset_pass_step_new']);
    Route::post('registration', [TrialClassApiController::class, 'registration']);
    Route::post('payment', [PaymentApiController::class, 'payment']);

    
    Route::get('home', [HomeApiController::class, 'home']);
    Route::get('parent-dashboard/{user_id}', [HomeApiController::class, 'parentDashboard']);
    Route::get('payments/{user_id}', [PaymentApiController::class, 'payments']);
    Route::get('make-payment/{student_id}', [PaymentApiController::class, 'makePayment']);
    Route::get('notif', [NotificationApiController::class, 'notif']);
    Route::get('student-profile/{student_id}', [StudentApiController::class, 'studentProfile']);
    Route::get('classes/{student_id}', [StudentApiController::class, 'studentsClasInfo']);
    Route::get('upcoming-trial-classes', [TrialClassApiController::class, 'upcomingTrialClasses']);
    Route::get('trial-class-schedule-date', [TrialClassScheduleApiController::class, 'trialClassScheduleDates']);
    Route::get('trial-class-schedule-time', [TrialClassScheduleApiController::class, 'trialClassScheduleTimes']);
    Route::get('dash-trial/{user_id}', [TrialClassApiController::class, 'showTrialClassDetails']);
    Route::get('track/{track_num?}', [ClassApiController::class, 'getTrackInformation']);
    Route::get('class/{user_id?}', [ClassApiController::class, 'getStudentClassDetails']);
    Route::get('parent/{user_id}', [TrialClassApiController::class, 'parent']);
    Route::get('student-trial-class-info/{student_id}', [TrialClassApiController::class, 'studentTrialClassInfo']);
    Route::get('payment-history/{parent_user_id}', [PaymentApiController::class, 'getChildrenPaymentHistoryOfAParent']);

    Route::post('/bkashApi/success', [BkashApiController::class, 'success']);
});