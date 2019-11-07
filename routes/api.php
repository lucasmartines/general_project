<?php

use Illuminate\Http\Request;

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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
if (App::environment('production')) {
    URL::forceScheme('https');
}



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/profile','API\UserController@profile');
Route::get('/findUser','API\UserController@search');

Route::put('/profile','API\UserController@updateProfile');

Route::apiResources(['user'=>'API\UserController']);
