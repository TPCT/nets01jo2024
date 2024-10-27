<?php

namespace App\Traits;
// use Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


Trait  HandleApiJsonResponseTrait
{
    // Log the API response details
    public function logResponse($result){
        Log::info('API Result:', [
            'URL'  => request()->fullUrl(),
            'Method' => request()->method(),
            'ip_address' => request()->ip(),
            'user-agent' => request()->header('user-agent'),
            'headers' => request()->headers->all(),
            // 'query_parameters' => request()->query->all(),
            'Data' => request()->all(),
            'user_id' => auth()->check() ? auth('api')->id() : 0,
            'Response' => $result,
        ]);
    }

    ###############################  START ERROR VALIDATE #############################
    public function errorValidate($validator):\Illuminate\Http\JsonResponse{
        return response()->json([
            'status' => false,
            'msg'    => $validator->errors()->first(),
            'data'   => (object)[],
        ],200);
    }
    ###############################  END ERROR VALIDATE   #############################
    ###############################    START NOT FOUND    #############################
    public function errorNotFound(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.Not Found'),
            'data'   => (object)[],
        ],200);
    }
    ###############################    END NOT FOUND      #############################
    ###############################    START SUCCESS      #############################
    public function success($data): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'msg'    => "success",
            'data'   => (object)$data,
        ],200);
    }
    ###############################    END SUCCESS        #############################
    ###############################    START UNEXPECTED   #############################
    public function errorUnExpected($ex): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => $ex->getMessage(),
            'data'   => (object)[]
        ],200);
    }
    ###############################    END UNEXPECTED     #############################
    ###############################    START ERROR        #############################
    public function error($message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => $message,
            'data'   => (object)[],
        ],200);
    }
    ###############################    END ERROR          #############################
    ###############################    START ERROR        #############################
    public function manyRequests(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.You have been blocked due to too many Request, try again later'),
            'data'   => (object)[],
        ],429);
    }
    ###############################    END ERROR          #############################

}
