<?php
namespace App\Services\ApiServices;

class UtilsApiServices{
    
    public function getOkResponse($payload)
    {
        return [
            "status" => 200,
            "message" => "Data Found",
            "payload" => $payload,
        ];
    }

    public function getNotFoundResponse()
    {
        return [
            "status" => 404,
            "message" => "No Data Found",
            "payload" => []
        ];
    }

    public function getValidationMessages($validator)
    {
        $response = array(
            'status' => false,
            'message' => $validator->errors(),
        );
        return response()->json($response, 422);
    }
}