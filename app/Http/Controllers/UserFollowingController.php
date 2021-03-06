<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\CustomResponse;
use App\Http\Services\UserFollowingService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Models\UserFollowing;
use Validator;

class UserFollowingController extends Controller
{
    private $customResponse, $userFollowingService, $userService;

    public function __construct(CustomResponse $customResponse, UserFollowingService $userFollowingService,
        UserService $userService)
    {
        $this->customResponse = $customResponse;
        $this->userFollowingService = $userFollowingService;
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = $this->userService->getCurrentUser();

        $data['follower_id'] = $user->id;
        $validator = Validator::make($data, UserFollowing::rules('store'));
        if($validator->fails()) {
            return $this->customResponse->response(null,[],$validator->errors()->all(),400);
        }
        if($user && $user->id == $data['followed_id']){
            return $this->customResponse->response(null,[],['You can\'t following yourself'],400);
        }
        // check  if current user following this user
        $isFollowing = $this->userFollowingService->checkIfCurrentUserFollowingSelectedUser($user->id,$data['followed_id']);
        if(!$isFollowing){
            $record = $this->userFollowingService->create($data);
            return $this->customResponse->response(null,['Your following saved successfully'],[],200);
        } else {
            return $this->customResponse->response(null,[],['You are following this user already'],400);
        }
    }
}
