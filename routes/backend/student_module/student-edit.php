<?php

use App\Http\Controllers\{CourseLevelController, StudentController, StudentAttendanceController, PaymentController};
use Illuminate\Support\Facades\{Route};

Route::prefix('student-tab')->group(function () {
    Route::get('/fetch-student/{id}', [StudentController::class, 'getStudentUsingId'])->name('fetch-student');
    Route::get('/fetch-roadmap/{id}', [CourseLevelController::class, 'getTrackLevelForRoadMap'])->name('fetch-roadmap');
    Route::get('/fetch-notes/{id}', [StudentController::class, 'getNotesOfStudent'])->name('fetch-notes');
    Route::get('/fetch-calls/{id}', [StudentController::class, 'getCallHistoryOfStudent'])->name('fetch-calls');
    Route::get('/fetch-attendance/{id}', [StudentAttendanceController::class, 'getStudentsAttendanceHistory'])->name('fetch-attendance');
    Route::get('/fetch-payment/{id}', [PaymentController::class, 'getStudentsPaymentHistory'])->name('fetch-payment');
});