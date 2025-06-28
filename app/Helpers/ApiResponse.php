<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message, $data = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message, $errors = null, $code = 400)
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
