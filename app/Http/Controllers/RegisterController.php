<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return ApiResponseMessageWithErrors('one or more fields validation required',$validator->errors(), 400);
        }
        $user = $this->authService->register($request->input('name'), $request->input('email'), $request->input('password'));
        return ApiResponseData($user);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, $this->roles());
    }

    private function roles()
    {
        $roles = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', 'min:8'],
        ];
        return $roles;
    }
}
