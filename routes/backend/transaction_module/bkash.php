<?php

use App\Http\Controllers\Backend\TransactionModule\Bkash\BkashController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'bkash'], function () {
    
    //index
    Route::get('/', [BkashController::class, 'index'])->name('bkash.index');
    
    //data
    Route::get('/data', [BkashController::class, 'data'])->name('bkash.data');

    // bkash info
    Route::post('/get-bkash-payment-info', [BkashController::class, 'getBkashPaymentInfo'])->name('bkash.info');

    
});