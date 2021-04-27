<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\CustomResponse;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Validator;
use PDF;

class ActionController extends Controller
{
    private $customResponse, $userService;

    public function __construct(CustomResponse $customResponse, UserService $userService)
    {
        $this->customResponse = $customResponse;
        $this->userService = $userService;
    }

    public function downloadReport()
    {
        $users = $this->userService->getUsersWithTweetsCount();
        $averageTweetsPerUser = ($users->sum('tweets_count')/ $users->count());
        $pdf = PDF::loadView('pdf.report', ['users' => $users,'averageTweetsPerUser' => $averageTweetsPerUser]);
        return $pdf->download('report.pdf');
    }
}
