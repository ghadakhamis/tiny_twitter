<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\CustomResponse;
use App\Http\Services\TweetService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Models\Tweet;
use Validator;

class TweetController extends Controller
{
    private $customResponse, $tweetService, $userService;

    public function __construct(CustomResponse $customResponse, TweetService $tweetService,
        UserService $userService)
    {
        $this->customResponse = $customResponse;
        $this->tweetService = $tweetService;
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $tweetData = $request->all();
        $user = $this->userService->getCurrentUser();
        if($user){
            $tweetData['user_id'] = $user->id;
            $validator = Validator::make($tweetData, Tweet::rules('store'));
            if($validator->fails()) {
                return $this->customResponse->response(null,[],$validator->errors()->all(),400);
            }
    
            $tweet = $this->tweetService->create($tweetData);
            return $this->customResponse->response(["tweet" => $tweet],['Your tweet saved successfully'],[],200);
        }
    }
}
