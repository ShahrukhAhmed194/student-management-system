<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait TrialClassScheduleValidators
{
    private $criteriaNewSchedule = [
        'age_from' => 'required|numeric|min:7|max:16',
        'age_to' => 'required|numeric|min:8|max:16',
        'country' => 'required',
        'date' => 'required|after_or_equal:today',
        'time' => 'required',
        'teacher_id' => 'required',
        'available_seats' => 'required|numeric|min:0|max:20'
    ], 
    $criteriaEditSchedule = [
        'age_from' => 'required|numeric|min:7|max:16',
        'age_to' => 'required|numeric|min:8|max:16',
        'country' => 'required',
        'date' => 'required',
        'time' => 'required',
        'teacher_id' => 'required',
        'available_seats' => 'required|numeric|min:0|max:20'
    ],
    $errorMessage = [
        'age_from.required' => 'Age From Is Required',
        'age_from.numeric' => 'Age From Must Be a Number',
        'age_from.min' => 'Age From Must Be Greater Than Or Equla :min',
        'age_from.max' => 'Age From Must Be Less Than Or Equla :max',
        'age_to.required' => 'Age To Is Required',
        'age_to.numeric' => 'Age To Must Be a Number',
        'age_to.min' => 'Age To Must Be Greater Than Or Equla :min',
        'age_to.max' => 'Age To Must Be Less Than Or Equla :max',
        'country.required' => 'Country Is Required',
        'date.required' => 'Date Is Required.',
        'date.after_or_equal' => 'Date Can Not Be Before Today.',
        'time.required' => 'Time Is Required',
        'teacher_id.required' => 'Teacher Is Required',
        'available_seats.required' => 'Available Seats Is Required.',
        'available_seats.numeric' => 'Available Seats Must Be A Number.',
        'available_seats.min' => 'Availabe Seats Can Not Be Less Than :min',
        'available_seats.max' => 'Available Seats Can Not Be More Than :max',
    ];

    public function validateNewSchedule(Request $request){
    
        return Validator::make($request->all(), 
            $this->criteriaNewSchedule, 
            $this->errorMessage
        );
    }

    public function validateExistingSchedule(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaEditSchedule, 
            $this->errorMessage
        );
    }
}