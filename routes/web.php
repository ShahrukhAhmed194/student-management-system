<?php

use App\Http\Controllers\{ClassScheduleController, CourseController, CourseLevelController, CourseTrackController, DaClassController, DashboardController, ParentController, PaymentController, ProjectController, QuizController, SessionController, SslCommerzPaymentController, StudentAttendanceController, StudentController, StudentProjectController, StudentQuizController, TrialClassController, TrialClassScheduleController, UserController, ReportController, StripeController, RoleController, ZoomController};
use App\Http\Controllers\BkashWebhookController;
use Illuminate\Support\Facades\{Auth, Route, Session};
use App\Http\Controllers\Api\BkashController;
use App\Models\LoginInfo;


//frontend route start
require_once 'frontend.php';
//frontend route end


Route::get('/payment/do', [PaymentController::class, 'paymentFormWithoutLogin']);
Route::post('get-parentinfo-byphone', [PaymentController::class, 'get_parentinfo_byphone'])->name('get-parentinfo-byphone');
Route::get('payment-form-auto-fill/{id}', [PaymentController::class, 'getAutoFillData']);
Route::post('/online-payment', [SslCommerzPaymentController::class, 'online_payment']);

Route::post('/validate-fieldsets', [TrialClassController::class, 'validateRegistrationStepByStep']);
Route::get('/forgot-password', [UserController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/password-reset-link', [UserController::class, 'emailPasswordResetLink'])->name('reset.email');
Route::get('/update-password', [UserController::class, 'showUpdatePassword'])->name('update.password');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password');


Route::get('error', function () {
    return view('pages.error-404');
});

Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    
    //backend route start
    require_once 'backend/web.php';
    //backend route end
    
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('my/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::get('logout', function () {
        LoginInfo::where('user_id', Auth::user()->id)
            ->latest('created_at')
            ->first()
            ->update([
                'logout_date' => date('Y-m-d'),
                'logout_time' => date('H:i:s'),
            ]);

        auth()->guard('web')->logout();
        Session::flush();
        return redirect()->route('login');
    });
});

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        // Parent routes
        Route::get('payment/fee', [PaymentController::class, 'create'])->name('payment.fee');
        // Route::get('payment/paymentFormWithoutLogin', [PaymentController::class, 'paymentFormWithoutLogin'])->name('paymentFormWithoutLogin');
        // Route::post('get-parentinfo-byphone', [PaymentController::class, 'get_parentinfo_byphone'])->name('get-parentinfo-byphone');
        Route::resource('payment', PaymentController::class);
        Route::get('childs', [StudentController::class, 'childs']);
        // Student routes
        Route::get('my-session-list/{id}', [SessionController::class, 'showAllSessionsForStudent']);
        // Route::get('payment-form-auto-fill/{id}', [PaymentController::class, 'getAutoFillData']);
        Route::get('/session/teacher/{id}', [SessionController::class, 'goToTeacherSession'])->name('session-teacher');
        Route::get('/session/student/{id}', [SessionController::class, 'goToStudentSession'])->name('session-student');
        Route::post('/session/student/specific', [SessionController::class, 'goToStudentSessionSpecific'])->name('session-student-specific');
        Route::post('/session/parent/specific', [SessionController::class, 'goToParentSessionSpecific'])->name('session-parent-specific');
        Route::post('/show-parent-sessions', [SessionController::class, 'showSessionDetailsToParent'])->name('show-parent-sessions');
        Route::post('/start/session/info', [SessionController::class, 'saveStartSessionData'])->name('start-session');
        Route::get('/end/session/info/{id}', [SessionController::class, 'saveEndSessionData'])->name('end-session');
        Route::post('/complete/session/data', [SessionController::class, 'saveSessionAsCompleted']);
        Route::get('/check-session-status/{id}', [SessionController::class, 'checkIfSessionStarted']);
        Route::post('/update-live-video', [SessionController::class, 'updateLiveVideo'])->name('update-live-video');
        Route::post('/update-live-video-single', [SessionController::class, 'updateLiveVideoSingle'])->name('update-live-video-single');
        Route::get('/update-recording-list', [SessionController::class, 'updateRecordingList']);
        Route::get('/save-video-from-lead-DB-dreamers-DB-by-class', [SessionController::class, 'saveVideoClassRecording']);
        Route::get('/session/create', [SessionController::class, 'createSession']);
        Route::post('/get-class-recordings', [SessionController::class, 'getClassRecordings']);
        Route::post('/create-custom-session', [SessionController::class, 'createCustomSession']);
        Route::get('/passed-recording', [SessionController::class, 'passed_recording']);
        Route::get('/passed-recording-edit/{id}', [SessionController::class, 'passed_recording_edit']);
        Route::post('/passed-recording-update', [SessionController::class, 'passed_recording_update'])->name('passed-recording-update');
        Route::get('/missing-session', [SessionController::class, 'missing_session'])->name('missing-session');
        Route::get('/add-new-session', [SessionController::class, 'add_new_session'])->name('add-new-session');
        Route::post('/teacher-wise-classes', [SessionController::class, 'teacherWiseClasses'])->name('teacher-wise-classes');
        Route::post('/session-save', [SessionController::class, 'session_save'])->name('session-save');
        
        //payment invoice
        Route::get('payment/{id}/invoice', [PaymentController::class, 'invoice']);
        Route::post('/class-session-participant-store', [SessionController::class, 'classSessionParticipantStore'])->name('class-session-participant-store');
        Route::post('/class-session-start', [SessionController::class, 'classSessionStart'])->name('class-session-start');
        Route::get('/class-session-migrate', [SessionController::class, 'classSessionMigrate'])->name('class-session-migrate');
        Route::get('/test-live-class', [SessionController::class, 'testLiveClass'])->name('test-live-class');
    }
);

Route::post('attendance/childs', [StudentAttendanceController::class, 'getAttendanceInfo']);
Route::get('get-childs-attendance-history/{id}', [StudentAttendanceController::class, 'getChildsAttendanceHistory']);

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::get('regular-class/list', [ClassScheduleController::class, 'regularClassList']);
        Route::resource('class-schedule', ClassScheduleController::class);
        Route::resource('attendance', StudentAttendanceController::class);
        Route::resource('project-assesment', StudentProjectController::class);
        Route::get('homework', [StudentProjectController::class, 'homework']);
        Route::get('homework-create', [StudentProjectController::class, 'homeworkCreate']);
        Route::POST('homework-store', [StudentProjectController::class, 'homeworkStore'])->name('homework-store');
        Route::resource('quiz-assesment', StudentQuizController::class);
        Route::get('trial-class-search', [TrialClassController::class, 'searchByDateGet']);
        Route::get('my-work-list', [TrialClassController::class, 'myWorkList']);
        Route::post('save-trial-class-call-history', [TrialClassController::class, 'saveTrialClassCallHistory']);
        Route::resource('trial-class', TrialClassController::class);
        Route::resource('trial-class-schedule', TrialClassScheduleController::class);
        Route::get('/inactive-schedule/{id}', [TrialClassScheduleController::class, 'inactiveClassSchedule']);
        Route::get('trial-class/attendance/{id}', [TrialClassController::class, 'attendanceTracking']);
        Route::post('submit-attendance', [TrialClassController::class, 'setAttendance']);
        Route::get('social-edit/{id}', [UserController::class, 'setSocialLinks']);
        Route::put('social-link/update/{id}', [UserController::class, 'updateSocialLink'])->name('social.update');
        Route::post('update-about/{id}', [UserController::class, 'updateAbout'])->name('about.update');
        Route::get('student-per-class/{id}', [ClassScheduleController::class, 'getStudentsPerClass']);
    }
);

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::get('/admin', function () {
            return view('dashboards.admin');
        })->name('admin');

        Route::resource('quiz', QuizController::class);
        Route::resource('class', DaClassController::class);
        Route::resource('project', ProjectController::class);
        Route::post('/track-wise-level', [ProjectController::class, 'trackWiseLevel'])->name('track-wise-level');
        Route::post('/course-wise-track', [ProjectController::class, 'courseWiseTrack'])->name('course-wise-track');
        Route::post('/course-wise-track', [ProjectController::class, 'courseWiseTrack'])->name('course-wise-track');
        Route::resource('course', CourseController::class);
        Route::resource('course-track', CourseTrackController::class);
        Route::resource('course-level', CourseLevelController::class);
        Route::resource('users', UserController::class);
        Route::get('active-inactive-user/{id}', [UserController::class, 'activeInactiveUserList'])->name('user-list');
        Route::resource('parents', ParentController::class);
        Route::resource('students', StudentController::class);
        Route::post('save-student-call-history', [StudentController::class, 'saveStudentCallHistory']);
        Route::get('/fetch-attachment/{id}', [StudentController::class, 'fetchAttachment'])->name('fetch-attachment');
        Route::post('/attachment-save', [StudentController::class, 'attachmentSave'])->name('attachment-save');
        Route::delete('/student-attachment-delete/{any}', [StudentController::class, 'studentAttachmentDelete'])->name('student-attachment-delete');
        Route::post('/attachment-show', [StudentController::class, 'attachmentShow'])->name('attachment-show');
        Route::post('/student-track-level-save', [StudentController::class, 'studentTrackLevelSave'])->name('student-track-level-save');
        Route::get('allstudents', [StudentController::class, 'allstudents']);
        Route::get('student-edit/{id}', [StudentController::class, 'studentEdit']);
        Route::put('allstudents-update/{id}', [StudentController::class, 'allstudents_update']);
        Route::get('students-terminated', [StudentController::class, 'showAllTerminatedStudents']);
        Route::get('students-graduated', [StudentController::class, 'showAllGraduatedStudents']);
        Route::get('/students-on-hold', [StudentController::class, 'getStudentsOnHold']);
        Route::get('/show-sales-report', [ReportController::class, 'showSalesReport']);
        Route::get('/show-instructor-report', [ReportController::class, 'showInstructorStudentCountReport']);
        Route::get('/show-trial-class-report', [ReportController::class, 'showTrialClassAdmissionReport']);
        Route::get('/show-students-monthly-report', [ReportController::class, 'showStudentsMonthlyReport'])->name('student-monthly-count-report');
        Route::get('/show-trial-class-sales-call-report', [ReportController::class, 'showTrialClassSalesCallReport'])->name('trial-class-sales-call-report');
        Route::get('/show-students-on-hold', [StudentController::class, 'showAllStudentsOnHold']);
        Route::get('report-show-comprehensively', [ReportController::class, 'index']);
        Route::get('/report-show-registrations', [ReportController::class, 'showRegistrationReports']);
        Route::post('report-show-date-status-count', [ReportController::class, 'getReportStatus']);
        Route::get('/show-student-monthly-termination-report', [ReportController::class, 'showStudentsMonthlyTerminationReport'])->name('student-monthly-termination-report');
        Route::get('/show-trial-class-payable-details-report', [ReportController::class, 'showTrialClassPayableDetailsReport'])->name('trial-class-payable-details-report');
        Route::get('/show-recording-mapping-missing-report', [ReportController::class, 'showRecordingMappingMissingReport'])->name('recording-mapping-missing-report');
        Route::get('/show-due-report', [ReportController::class, 'showDueReport'])->name('due-report');
        Route::get('/show-utm-medium-report', [ReportController::class, 'showUTMMediumReport'])->name('utm-medium-report');
        Route::get('payment-history', [PaymentController::class, 'getAllPaymentHistory'])->name('payment.history');
        Route::post('filter-payment-history', [PaymentController::class, 'filter_payment_history']);
        Route::get('payment-add-new', [PaymentController::class, 'addNewPayment'])->name('payment.add_new');
        Route::post('load-allchild', [PaymentController::class, 'load_allchild']);
        Route::get('/payment-edit/{id}', [PaymentController::class, 'payment_edit']);
        Route::post('add-payment-by-admin', [PaymentController::class, 'addPaymentByAdmin']);
        Route::post('update-payment-by-admin', [PaymentController::class, 'updatePaymentByAdmin']);
        Route::post('/payment-details', [PaymentController::class, 'getPaymentDetails'])->name('payment-details');
        Route::get('inactive-class/{id}', [StudentAttendanceController::class, 'inactiveClass']);
        Route::get('report-show-attendance', [StudentAttendanceController::class, 'showStudents']);

        Route::get('class-students/{id}', [StudentController::class, 'showStudentsPerClass']);

        Route::get('class-details', [DaClassController::class, 'showClassDetails']);

        // Trial Class Edit page date and time routes
        Route::post('/get-trial-class-schedules', [TrialClassController::class, 'getTrialClassSchedules']);
        Route::post('/get-trial-class-times', [TrialClassController::class, 'getTrialClassTimes']);
        Route::post('/trialclass-student-name-email-phone-check', [TrialClassController::class, 'trialclassStudentNameEmailPhoneCheck']);
    }
);


//dashboard.js and dashboard-chart.js routes 

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/active-students', [DashboardController::class, 'getActiveStudents']);
    Route::get('/terminated-students', [DashboardController::class, 'getTerminatedStudents']);
    Route::get('/graduated-students', [DashboardController::class, 'getGraduatedStudents']);
    Route::get('/total-students', [DashboardController::class, 'getTotalStudents']);
    Route::get('/trial-class-students-today', [DashboardController::class, 'getTrialClassStudentsToday']);
    Route::get('/trial-class-students-yesterday', [DashboardController::class, 'getTrialClassStudentsYesterday']);
    Route::get('/trial-class-students-tomorrow', [DashboardController::class, 'getTrialClassStudentsTomorrow']);
    Route::get('/payments-receivied', [DashboardController::class, 'getPaymentReceivedStudents']);
    Route::get('/due-payments', [DashboardController::class, 'getDuePaymentStudents']);
    Route::get('/total-myWorkList', [DashboardController::class, 'getTotalMyworklist']);
    Route::get('/total-registrations', [DashboardController::class, 'getTotalRegistrations']);
    Route::get('/students-count-by-teacher', [DashboardController::class, 'getStudentsCountByTeacher']);
    Route::get('/students-count-by-country', [DashboardController::class, 'getStudentsCountByCountry']);

    // dashboard-chart routes
    Route::get('/students-count-by-age', [DashboardController::class, 'getStudentsCountByAge']);
    Route::get('/students-count-by-gender', [DashboardController::class, 'getStudentsCountByGender']);

    // dashboard count routes
    Route::get('/show-total-students', [StudentController::class, 'showTotalStudents']);
    Route::get('/show-trial-class-students-today', [DashboardController::class, 'showTrialClassStudentsToday']);
    Route::get('/show-trial-class-students-yesterday', [DashboardController::class, 'showTrialClassStudentsYesterday']);
    Route::get('/show-trial-class-students-tomorrow', [DashboardController::class, 'showTrialClassStudentsTomorrow']);
    Route::get('/show-payment-received-students', [DashboardController::class, 'showPaymentReceivedStudents']);
    Route::get('/show-due-payment-students', [DashboardController::class, 'showDuePaymentStudents']);
    Route::get('/show-active-payment-students', [DashboardController::class, 'showActivePaymentStudents']);

    Route::get('/zoom', [zoomController::class, 'index'])->name('zoom');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// ============== stripe payment gateway ==============
Route::get('stripe', [StripeController::class, 'stripe']);
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');

//============= its for roles & permission ===============

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::resource('roles', RoleController::class);
    Route::get('/assign-role', [RoleController::class, 'assign_role_form'])->name('assign-role');
    Route::post('/assigned-role', [RoleController::class, 'assign_role'])->name('assigned-role');
    Route::get('/permission', [RoleController::class, 'permission'])->name('permission');
    Route::post('/permission-save', [RoleController::class, 'permission_save'])->name('permission-save');
    Route::get('/permission-edit/{any}', [RoleController::class, 'permission_edit'])->name('permission-edit');
    Route::put('/permission-update/{any}', [RoleController::class, 'permission_update'])->name('permission-update');
    Route::delete('/permission-delete/{any}', [RoleController::class, 'permission_delete'])->name('permission-delete');
    Route::get('/assign-role-list', [RoleController::class, 'assignrole_list'])->name('assign-role-list');
    Route::get('/assignuserrole-edit/{any}', [RoleController::class, 'assignuserrole_edit'])->name('assignuserrole-edit');
    Route::put('/assigned-role-update/{any}', [RoleController::class, 'assignedrole_update'])->name('assigned-role-update');
    Route::get('/assignuserrole-delete/{any}', [RoleController::class, 'assignuserrole_delete'])->name('assignuserrole-delete');
});

// =======================Bkash Payment Routes=====================
// Checkout (URL) User Part
Route::get('/bkash/pay', [BkashController::class, 'payment'])->name('url-pay');
Route::post('/bkash/create', [BkashController::class, 'createPayment'])->name('url-create');
Route::get('/bkash/callback', [BkashController::class, 'callback'])->name('url-callback');

// Checkout (URL) Admin Part
Route::group(['middleware' => ['auth:sanctum', 'role:Super-Admin']], function () {
    Route::get('/bkash/refund', [BkashController::class, 'getRefund'])->name('url-get-refund');
    Route::post('/bkash/refund', [BkashController::class, 'refundPayment'])->name('url-post-refund');
});


//bkash webhook
Route::post('/bkash/webhook', [BkashWebhookController::class, 'webhookListener'])->name('bkash.webhook');