<?php

use App\User;
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

Route::get('/users', 'KPBI\ProfileAPIController@getAllProfiles')->middleware('api');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/kpbi/profile', function (Request $request) {
    return $request->user()->kpbi_profile;
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
