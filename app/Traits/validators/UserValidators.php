<?php

namespace App\Traits\validators;

use App\Models\User;
use App\Rules\ValidateExistingUsersEmail;
use App\Rules\ValidateExistingUsersName;
use App\Rules\validPhoneNumber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait UserValidators
{
    public function validateUser(Request $request){
    
        if($request->user_type == User::USER_TYPE_TEACHER){
            return Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required','email', new ValidateExistingUsersEmail($request->id)],
                'user_name' => ['required','max:255', new ValidateExistingUsersName($request->id)],
                'phone' => ['nullable', new validPhoneNumber],
                'user_type' => 'required',
                'zoom_topic' => 'required',
                'zoom_meeting_id' => 'required|integer',
                'zoom_password' => 'required'
            ]);
        }else{
            return Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required','email', new ValidateExistingUsersEmail($request->id)],
                'user_name' => ['required','max:255','regex:/^\S*$/u', new ValidateExistingUsersName($request->id)],
                'phone' => ['nullable', new validPhoneNumber],
                'user_type' => 'required'
            ]);
        }
        
    }
}