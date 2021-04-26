<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Responses\CustomResponse;
use Closure;

class CustomAuthenticate extends BaseMiddleware
{
    private $customResponse;

    public function __construct(CustomResponse $customResponse,JWTAuth $auth)
    {
        $this->customResponse = $customResponse;
        parent::__construct($auth);
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
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            return $this->customResponse->response(null,[],['Token not provided'],401);
        }
        try {
            if (! $this->auth->parseToken()->authenticate()) {
                return $this->customResponse->response(null,[],['User not found'],404);
            }
        } catch (JWTException $e) {
            return $this->customResponse->response(null,[],[$e->getMessage()],401);
        }

        return $next($request);
    }
}
