<?php

namespace App\Exceptions;

use App\Exceptions\CustomErrorHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Log;
use Mail;
use App\Mail\ErrorExceptionMailer;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
            
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {
        $this->reportable(function (Throwable $e) {
            $exceptiondata = (new CustomErrorHandler($e));
        });
    }

}
