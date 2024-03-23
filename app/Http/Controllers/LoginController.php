<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails())
            return ApiResponseMessageWithErrors('',$validator->errors(),400);
        if($token = $this->authService->login($request->input('email'),$request->input('password')))
            return ApiResponseDataWithMessage($token,"Logged in successfully");

        return ApiResponseMessage("These credentials do not match our records.",400);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'     => ['required', 'string', 'max:255','email'],
            'password'  => ['required', 'string', 'min:6'],
        ]);
    }
}
