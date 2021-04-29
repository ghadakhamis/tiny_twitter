<?php

namespace App\Http\Middleware;

use App\Http\Responses\CustomResponse;
use App\Http\Services\UserService;
use App\Http\Services\FailedLoginAttemptService;
use Closure;

class checkEmailIfBlocked
{
    private $customResponse, $userServiceUserService,$failedLoginAttemptService;

    public function __construct(CustomResponse $customResponse,UserService $userService,
        FailedLoginAttemptService $failedLoginAttemptService)
    {
        $this->customResponse = $customResponse;
        $this->userService = $userService;
        $this->failedLoginAttemptService = $failedLoginAttemptService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->userService->getCurrentUser();
        if(!$user){
            return $this->customResponse->response(null,[],['User not found'],404);
        }
        // check if email blocked or not
        $isBlocked = $this->failedLoginAttemptService->checkIfEmailIsBlocked($user->email);
        if($isBlocked){
            return $this->customResponse->response(null,[],['You are blocked for ' . config('failedLogin.blockedTimeInMinutes') . ' minutes'],400);
        }
        return $next($request);
    }
}
