<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

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

Route::group(['prefix' => 'api'], function () {
    Route::group([
        'prefix' => 'kpbi',
        'namespace' => 'KPBI'
    ], function () {
        Route::get('/profile', 'ProfileAPIController@get')->middleware('auth:api');
        Route::put('/profile', 'ProfileAPIController@update')->middleware('auth:api');
        Route::get('/profiles', 'ProfileAPIController@getAll');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        $user = $request->user();
        return response()->json($user->toArray() + ['verified' => $user->hasVerifiedEmail()]);
    });

    // Route::get('tes', function (Request $request) {
    // })->middleware('auth:api');

    Route::group([
        'prefix' => 'auth',
        'namespace' => 'Auth\API'
    ], function () {
        Route::post('login', 'BasicController@login');
        Route::post('register', 'RegisterController@register');
        
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('logout', 'BasicController@logout');
            Route::get('user', 'BasicController@user');
        });
    });
});

Route::group([
    'prefix' => 'verify',
    'as' => 'verification'
], function () {
    Route::post('/{id}', 'Auth\API\VerificationController@verify')->name('.verify');
    Route::get('/resend', 'Auth\API\VerificationController@resend')->name('.resend');
});