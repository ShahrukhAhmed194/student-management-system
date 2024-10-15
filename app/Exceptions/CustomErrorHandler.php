<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Mail;
use App\Mail\ErrorExceptionMailer;

class CustomErrorHandler extends Exception
{
    public function __construct($exception) {
        $this->exception = $exception;
        $this->sendEmail($this->exception);
    }

    public function sendEmail(Throwable $exception) {
        try {

            $content['message'] = $exception->getMessage();
            $content['file'] = $exception->getFile();
            $content['line'] = $exception->getLine();
            $content['trace'] = $exception->getTrace();

            $content['url'] = request()->url();
            $content['body'] = request()->all();
            $content['ip'] = request()->ip();
            if(config('app.env') === 'production'){
                Mail::to('dreamersacademy.xyz@gmail.com')
                    ->cc(['shahrukh.dreamers@gmail.com', 'bsagor.test@gmail.com', 'shahabuddinp91@gmail.com', 'rkmahbub.workspace@gmail.com'])
                    ->send(new ErrorExceptionMailer($content));
            }
            
        } catch (Throwable $exception) {
            Log::error($exception);
        }
    }
}
