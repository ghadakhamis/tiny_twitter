<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'],
    function () {
        Route::post('upload-image','UploadController@uploadImage')->name('upload.image');
        Route::post('authenticate/register', 'AuthenticateController@registration');  
        Route::post('authenticate','AuthenticateController@login');      
});

Route::group(['prefix' => 'v1','middleware' => ['custom.auth','email.blocked']],
    function () {
        Route::post('tweets','TweetController@store');    
        Route::post('following-users','UserFollowingController@store');     
        Route::get('actions/report','ActionController@downloadReport');        

});
