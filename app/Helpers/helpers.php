<?php


if (! function_exists('ApiResponseDataWithMessage')) {
    function ApiResponseDataWithMessage($data,$message='' , $code=200 )
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
function ApiResponseMessageWithErrors($message,$errors, $code=200)
{
    return response()->json([
        'code'    => $code,
        'message' => $message,
        'ErrorCode' => 1400,
        'errors'  => $errors
    ], $code);
}

if (! function_exists('ApiResponseData')) {
    function ApiResponseData($data , $code=200)
    {
        return response()->json([
            'code' => $code,
            'data' => $data
        ], $code);
    }
}

if (! function_exists('ApiResponseMessage')) {
    function ApiResponseMessage($message, $code=200,$error_code=null)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'ErrorCode' => $error_code
        ], $code);
    }
}
