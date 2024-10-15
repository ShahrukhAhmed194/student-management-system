<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function generic_mail(Request $request)
    {
        $requested_data = $request->all();
        $data = json_decode(json_encode($requested_data), FALSE);

        Mail::to($request->to)->send(new SendEmail($data));

        return 'Mail sent successfully';
    }
}
