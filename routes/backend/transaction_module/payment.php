<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

//delete payment
Route::post('/payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
