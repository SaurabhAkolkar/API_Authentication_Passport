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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', ['AuthController','register']);
Route::post('getotp', ['AuthController','getOTP']);
Route::post('verifyotp', ['AuthController','verifyOTP']);


Route::group(['middleware'=>['auth:api','isadmin']],function(){
    Route::post('replycomplaint/{compt_id}', ['ComplaintApi','replyComplaint']);
});

Route::group(['middleware'=>['auth:api','iscustomers']],function(){
    Route::post('addcomplaint', ['ComplaintApi','addComplaint']);
});