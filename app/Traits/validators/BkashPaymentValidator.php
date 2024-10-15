<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait BkashPaymentValidator
{
    public function validateBkashPaymentOfParent(Request $request)
    {
        return Validator::make($request->all(), [
                'bkash_student_id' => 'required',
                'bkash_fees' => 'required',
                'bkash_installment' => 'required',
                'bkash_transaction_purpose' => 'required',
                'bkash_transaction_type' => 'required',
                'bkash_for_month' => 'required',
                'bkash_agreement' => 'required'
            ],
            [
                'bkash_student_id.required' => "Please select your child",
                'bkash_fees.required' => "No amount is given",
                'bkash_installment.required' => 'Number of installment is required',
                'bkash_transaction_purpose.required' => 'Transaction purpose is required',
                'bkash_transaction_type.required' => 'Transaction type is required',
                'bkash_for_month.required' => 'Select the name of payment month(s)',
                'bkash_agreement.required' => 'You need to agree to our terms and conditions'
            ]
        );
    }

    public function validateBkashPaymentOfAndroidApp(Request $request)
    {
        return Validator::make($request->all(), [
            'transaction_id' => 'required',
            'student_id' => 'required',
            'invoice_id' => 'required',
            'fees' => 'required',
            'date' => 'required',
            'installment' => 'required',
            'transaction_purpose' => 'required',
            'transaction_type' => 'required',
            'for_month' => 'required',
            'agreement' => 'required',
        ],
        [
            'transaction_id.required' => "No transaction ID found",
            'student_id.required' => "Please select your child",
            'invoice_id.required' => "No invoice ID found",
            'fees.required' => "No amount is given",
            'date.required' => "Transaction date not found",
            'installment.required' => 'Number of installment is required',
            'transaction_purpose.required' => 'Transaction purpose is required',
            'transaction_type.required' => 'Transaction type is required',
            'for_month.required' => 'Select the name of payment month(s)',
            'agreement.required' => 'You need to agree to our terms and conditions',
        ]
    );
    }
}