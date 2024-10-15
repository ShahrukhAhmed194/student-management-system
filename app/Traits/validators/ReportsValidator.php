<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait ReportsValidator{

    private $date_without_range_rules = [
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ],
    $date_with_range_rules = [
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'date_range' => 'required|after:end_date'
    ],
    
    $error_messages = [
        'start_date.required' => "Please provide start date.",
        'start_date.before' => "Start date must be before end date.",
        'end_date.required' => 'Please provide end date.',
        'end_date.after' => 'End date must be after start date.',
        'date_range.required' => 'Something went wrong.',
        'date_range.after' => 'The range for searching report is one month.'
    ];

    public function validateSearchParamsOfSalesReport(Request $request){
        if($request->start_date){
            $date = Carbon::createFromFormat('Y-m-d', $request->start_date)->addDays(32);
            $request->request->add(['date_range' => $date->format('Y-m-d')]);

            $validator = Validator::make($request->all(),
                $this->date_without_range_rules,
                $this->error_messages
            );
        }else{
            $validator = Validator::make($request->all(),
                $this->date_without_range_rules,
                $this->error_messages
            );
        }

        return $validator;
        
    }
}