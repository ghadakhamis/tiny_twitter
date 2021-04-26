<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\CustomResponse;
use App\Http\Models\User;
use App\Http\Services\UserService;
use App\Http\Services\FailedLoginAttemptService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Validator;

class AuthenticateController extends Controller
{

    private $userService, $customResponse, $failedLoginAttemptService;

    public function __construct(UserService $userService, CustomResponse $customResponse,
        FailedLoginAttemptService $failedLoginAttemptService)
    {
        $this->userService = $userService;
        $this->customResponse = $customResponse;
        $this->failedLoginAttemptService = $failedLoginAttemptService;
    }

    public function registration(Request $request)
    {
        $userData = $request->all();

        $validator = Validator::make($userData, User::rules('register'));
        if($validator->fails()) {
            return $this->customResponse->response(null,[],$validator->errors()->all(),400);
        }
        $user = $this->userService->create($userData);
        $token = JWTAuth::fromUser($user);
        return $this->customResponse->response(["token" => $token],['Your data saved successfully'],[],200);
    }

    public function login(Request $request){
        $userData = $request->all();

        $validator = Validator::make($userData, User::rules('login'));
        if($validator->fails()) {
            return $this->customResponse->response(null,[],$validator->errors()->all(),400);
        }
        $user = $this->userService->loginUser($request->email,$request->password);
        if($user){
            // check if email blocked or not
            $isBlocked = $this->failedLoginAttemptService->checkIfEmailIsBlocked($request->email);
            if(!$isBlocked){
                $token = JWTAuth::fromUser($user);
                return $this->customResponse->response(["token" => $token],['Your data is corrected'],[],200);
            } else {
                return $this->customResponse->response(null,[],['You are blocked for ' . config('failedLogin.blockedTimeInMinutes') . ' minutes'],400);
            }
        } else {
            // add faild login attempts
            $this->failedLoginAttemptService->create(['email' => $request->email,'failed_login_time' => Carbon::now(),'IP' => $request->ip()]);
            return $this->customResponse->response(null,[],['Email or password not correct'],400);
        }  
    }
}
