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

Route::group([
    'prefix' => 'kpbi',
    'namespace' => 'KPBI'
], function () {
    
    Route::get('/profile', 'ProfileAPIController@get')->middleware('auth:api');
    Route::put('/profile', 'ProfileAPIController@update')->middleware('auth:api');
    Route::get('/profiles', 'ProfileAPIController@getAll')->middleware('api');
    
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth\API'
], function () {
    Route::post('login', 'BasicController@login');
    Route::post('signup', 'BasicController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('logout', 'BasicController@logout');
        Route::get('user', 'BasicController@user');
    });
});
