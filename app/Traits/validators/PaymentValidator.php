<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait PaymentValidator
{
    private $new_pay_rule = [
        'student_id' => 'required|numeric',
        'fees' => 'required|numeric',
        'date' => 'required|date|before:2099-01-01|after:2021-01-01',
        'transaction_type' => 'required',
        'for_month' => 'required',
        'installment' => 'required|numeric',
        'transaction_id' => 'required|unique:payments',
        'transaction_purpose' => 'required'
    ],
    $update_pay_rule = [
        'student_id' => 'required',
        'fees' => 'required|numeric',
        'date' => 'required|date|before:2099-01-01|after:2021-01-01',
        'transaction_type' => 'required',
        'for_month' => 'required',
        'installment' => 'required|numeric',
        'transaction_id' => 'required',
        'transaction_purpose' => 'required'
    ],
    $error_messages = [
        'student_id.required' => "Please select a student",
        'fees.required' => "No amount is given",
        'date.required' => 'Please select a date',
        'transaction_type.required' => 'Transaction type is required',
        'for_month.required' => 'Select the name of payment months',
        'installment.required' => 'Number of installment is required',
        'transaction_id.required' => 'Transaction id is required',
        'transaction_id.unique' => 'This transaction id has already been used',
        'transaction_purpose.required' => 'Transaction purpose is required'
    ];

    public function validatePaymentByAdmin(Request $request)
    {
        return Validator::make($request->all(),
            $this->new_pay_rule,
            $this->error_messages
        );
    }

    public function validateParentsSSLpayment(Request $request)
    {
        return Validator::make($request->all(), [
            'student_id' => 'required',
            'fees' => 'required',
            'installment' => 'required',
            'transaction_purpose' => 'required',
            'for_month' => 'required',
            'agreement' => 'required'
        ],
        [
            'student_id.required' => "Please select a student",
            'fees.required' => "No amount is given",
            'installment.required' => 'Number of installment is required',
            'transaction_purpose.required' => 'Transaction purpose is required',
            'for_month.required' => 'Select the name of payment months',
            'agreement.required' => 'Please acknowledge that you have read our terms and policies'
        ]
    );
    }

    public function validatePaymentUpdateByAdmin(Request $request)
    {
        return Validator::make($request->all(),
            $this->update_pay_rule,
            $this->error_messages
        );
    }
}