<?php 

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\IfEmailExists;

trait PasswordResetValidator
{
    
    public function validatePasswordResetEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => ['required','email', new IfEmailExists]
        ]);
    }

    public function validateNewPassword(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => ['required','email', new IfEmailExists],
            'password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation'
        ]);
    }
}