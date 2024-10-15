<?php

namespace App\Traits\validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait TrialClassValidators
{
    public function validateFirstFieldset(Request $request)
    {
        return Validator::make($request->all(), [
                'student_name' => 'required',
                'gender' => 'required',
                'school' => 'required',
                'hasDevice' => 'required',
                'hear_from' => 'required'
            ],
            [
                'student_name.required' => "Child's name is required",
                'gender.required' => "Child's gender is required",
                'school.required' => 'School name is required',
                'hasDevice.required' => 'Do you have Laptop/Desktop is required',
                'hear_from.required' => 'Where did you hear from us is required'
            ]
        );
    }

    public function validateSecondFieldset(Request $request)
    {
        return Validator::make($request->all(), [
                'country' => 'required',
                'age' => 'required',
                'date' => 'required',
                'trial_class_id' => 'required'
            ],
            [
                'country.required' => "Country is required",
                'age.required' => "Age is required",
                'date.required' => 'Date is required',
                'trial_class_id.required' => 'Time is required'
            ]
        );
    }

    public function validateThirdFieldset(Request $request)
    {
        return Validator::make($request->all(), [
                'gurdian_name' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'occupation' => 'required'
            ],
            [
                'gurdian_name.required' => "Guardian's name is required",
                'phone.required' => "Phone number is required",
                'phone.numeric' => "Phone number is invalid",
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'occupation.required' => 'Do you have Laptop/Desktop is required',
            ]
        );
        
    }

    public function validatePayableAmmount(Request $request){
        return Validator::make($request->all(), [
            'payable_amount' => 'required|numeric'
        ],
        [
            'payable_amount.required' => "Payable amount is required",
            'payable_amount.numeric' => "Payable amount must be a number",
        ]
    );
    }
}