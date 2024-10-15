<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

//dashboard data route start

    Route::get('get-students-not-assigned-count', [DashboardController::class, 'getStudentsNotAssignedCount'])->name('get.students.not.assigned.count');
    
    Route::get('get-advanced-payment-count', [DashboardController::class, 'getAdvancedPaymentCount'])->name('get.advanced.payment.count');
    
    Route::get('get-non-advanced-payment-count', [DashboardController::class, 'getNonAdvancedPaymentCount'])->name('get.non.advanced.payment.count');
    
    Route::get('get-wrong-payment-count', [DashboardController::class, 'getWrongPaymentCount'])->name('get.wrong.payment.count');
    
    Route::get('get-month_due-count/{month}', [DashboardController::class, 'getMonthDueCount'])->name('get.month.due.count');

    Route::get('get-wrong_due-count', [DashboardController::class, 'getWrongDueCount'])->name('get.wrong.due.count');

//dashboard data route end

//trial class route
require_once 'trial_class_module/trial_class.php';

//certificate module route
require_once 'certificate_module/certificate.php';

//transaction module route start
Route::group(['prefix' => 'transaction-module'], function () {
    require_once 'transaction_module/bkash.php';
    require_once 'transaction_module/payment.php';
});
//transaction module route end





// student module routes
require_once 'student_module/student-edit.php';
