<?php

namespace App\Traits\Api\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait ApiValidator
{
    private $criteriaRegisterData = [
        'name' => 'required|string|max:100',
        'email' => 'required|string|email|max:100|unique:users',
        'password' => 'required|string|min:6',
    ],
    $criteriaUsernamePassword = [
        'user_name' => 'required|string',
        'password' => 'required|string|min:8',
    ],
    $criteriaEmailPasswordValidate = [
        'email' => 'required|string|email',
        'password' => 'required|string|min:8',
    ],
    $criteriaTrialClassRegistration = [
        'parent_name' => 'required|string',
        'phone_number' => 'required|string',
        'email' => 'required|string|email',
        'profession' => 'required|string',
    ],
    $criteriaPaymentDataValidate = [
        'student_id' => 'required',
        'amount' => 'required',
        'installment' => 'required',
        'purpose' => 'required',
        'for_month' => 'required',
        'agreement' => 'required',
        'transaction_type' => 'required',
        'transaction_id' => 'required',
        'invoice_id' => 'required',
        'payment_status' => 'required',
        'bkash_response' => 'required'
    ],
    $criteriaResetPasswordEmail = [
        'email' => 'required|string|email',
    ];

    public function registerDataValidate(Request $request){
    
        return Validator::make($request->all(), 
            $this->criteriaRegisterData
        );
    }
    public function usernamePasswordValidate(Request $request){
    
        return Validator::make($request->all(), 
            $this->criteriaUsernamePassword
        );
    }

    public function trialClassRegistrationValidate(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaTrialClassRegistration
        );
    }

    public function resetPassEmailValidate(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaResetPasswordEmail
        );
    }

    public function resetEmailPasswordValidate(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaEmailPasswordValidate
        );
    }

    public function paymentDataValidate(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaPaymentDataValidate
        );
    }
}