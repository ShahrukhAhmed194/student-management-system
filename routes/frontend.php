<?php

use App\Http\Controllers\TrialClassRegistrationController;
use Illuminate\Support\Facades\Route;


// Trial Class Registration
Route::get('/trial-class-registration', [TrialClassRegistrationController::class, 'create'])->name('trial.class.registration');

Route::post('/trial-class-registration', [TrialClassRegistrationController::class, 'store'])->name('trial.class.registration.store');

// Get Trial Class Registration Date
Route::get('/get-trial-class-registration-date', [TrialClassRegistrationController::class, 'getTrialClassRegistrationDate'])->name('get.trial.class.registration.date');

// Get Trial Class Registration Time
Route::get('/get-trial-class-registration-time', [TrialClassRegistrationController::class, 'getTrialClassRegistrationTime'])->name('get.trial.class.registration.time');

// Trial Class Registration Success
Route::get('/trial-class-registration/success', [TrialClassRegistrationController::class, 'success'])->name('trial.class.registration.success');
