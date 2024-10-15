<?php

namespace App\Traits\validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait RoleValidator
{
    private $criteriaNewRole = [
        'name' => 'required|max:100|unique:roles',
    ], 
    $criteriaUpdateRole = [
        'name' => 'required|max:100',
    ],
    $errorMessage = [
        'name.required' => 'Role Name Is Required',
    ];

    public function validateNewRole(Request $request){
    
        return Validator::make($request->all(), 
            $this->criteriaNewRole, 
            $this->errorMessage
        );
    }

    public function validUpdatedForm(Request $request){
    
        return Validator::make($request->all(),
            $this->criteriaUpdateRole, 
            $this->errorMessage
        );
    }
}