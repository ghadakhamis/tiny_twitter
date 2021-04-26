<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\CustomResponse;
use App\Http\Services\UploadFileService;
use Illuminate\Http\Request;
use Validator;

class UploadController extends Controller
{
    private $customResponse, $uploadFileService;

    public function __construct(CustomResponse $customResponse, UploadFileService $uploadFileService)
    {
        $this->customResponse = $customResponse;
        $this->uploadFileService = $uploadFileService;
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,jpg,png|max:'.config('uploadFiles.maxSize')
        ]);
        if ($validator->fails()) {
            return $this->customResponse->response(null,[],$validator->errors()->all(),400);
        }

        $url= $this->uploadFileService->uploadFile($request->file,'/images');
        if($url){
            return $this->customResponse->response(['url' => $url],['Image uploaded successfully'],[],200);
        } else {
            return $this->customResponse->response(null,[],['Image not uploaded'],400);
        }
    }
}
