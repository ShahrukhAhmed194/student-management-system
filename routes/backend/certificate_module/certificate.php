<?php

use App\Http\Controllers\Backend\CertificateModule\CertificateController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'certificate'], function () {
    
    //index
    Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
    
    //pdf certificate
    Route::get('/export/pdf/{id}/{level_id}', [CertificateController::class, 'exportPdf'])->name('certificate.export.pdf');
    
});

