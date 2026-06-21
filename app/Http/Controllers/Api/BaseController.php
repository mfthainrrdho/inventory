<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Success response wrapper
     */
    protected function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error response wrapper
     */
    protected function error($message = null, $code = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}