<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApiResponse{

    /** Return a success JSON response.
     * 
     * @param array|string $data
     * @param string| $message
     * @param int|null $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null,int $code =200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ],$code);
    }

    /** Return a success JSON response.
     * 
     * @param array|string $data
     * @param string| $message
     * @param int|null $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, int $code, $data = null)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ],$code);
    }

}