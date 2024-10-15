<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    
    /**
     * To handel success response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function success(?string $message = null, $data = null, $code = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }
    
    /**
     * To handel warning response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function warning(?string $message = null, $data = null, $code = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'warning',
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }
    
    /**
     * To handel error response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function error(?string $message = null, $data = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    
    /**
     * To handel redirect response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function redirect(?string $message = null, $url = null, $data = null, $redirect = true, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'redirect' => $redirect,
            'url' => $url,
        ], $code);
    }
}

