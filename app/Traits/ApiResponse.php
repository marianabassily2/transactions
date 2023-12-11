<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;


trait ApiResponse
{

    /**
     * success response method with data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message ,$code =200):JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

      /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccess($message ,$code =200) : JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404):JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
