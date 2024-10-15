<?php

use App\Http\Controllers\Backend\TrialClassModule\TeacherTrialClassController;
use Illuminate\Support\Facades\Route;

Route::get('trial-class-list', [TeacherTrialClassController::class, 'index'])->name('teacher.trial.class.index');

Route::get('trial-class/{condition}', [TeacherTrialClassController::class, 'trialClass'])->name('teacher.trial.class');

Route::get('trial-class-data', [TeacherTrialClassController::class, 'trialClassData'])->name('teacher.trial.class.data');
