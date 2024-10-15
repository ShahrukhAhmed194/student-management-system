<?php

namespace App\Traits\users;

use App\Models\Token;
use App\Models\User;
use App\Traits\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait ForgetPassword
{
    use Utils;
    public function getDataSetToEmail($email)
    {
        $user = User::where('email', $email)->first();
        $token = $this->getUniqueId(15);

        Token::create([
            'user_id' => $user->id,
            'email' => $email,
            'token' => $token
        ]);

        $dataSet = [
            'email' => $email,
            'subject' => 'Password Reset',
            'token' => $token
        ];

        return $dataSet;
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function matchTokenFromTable($token)
    {
        return Token::where('token', $token)->first();
    }
}