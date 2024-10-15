<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait SessionValidator
{
    public function validateCustomSession(Request $request)
    {
        return Validator::make($request->all(), [
                'meetingDate' => 'required',
                'startTime' => 'required',
                'classId' => 'required',
                'classRecording' => 'required'
            ],
            [
                'meetingDate.required' => "Please provide a meeting date.",
                'startTime.required' => "Please provide meeting start time.",
                'classId.required' => 'No class is selected.',
                'classRecording.required' => 'No session information is given.'
            ]
        );
    }
}