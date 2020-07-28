<?php

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Auth::routes([
//     'register' => false,
//     'verify' => true,
// ]);

// Route::get('/members', 'HomeController@members')->name('memberList');
Route::get('api/auth', function () {
    return response()->json(auth()->user() ? auth()->user() : ['error' => 'Belum login']);
});
Route::get('api/kpbi/profile', function () {
    if ($authenticatedUser = auth()->user()) {

        $kpbi_profile = $authenticatedUser->kpbi_profile;
        $res = Arr::dot($kpbi_profile->attributesToArray());

    } else {
        $res = ['error' => 'Belum login'];
    }

    return response()->json($res);
});
Route::get('api/kpbi/profile/{id}', function ($id) {
    return response()->json(User::find($id)->kpbi_profile);
});

Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');


Route::post('/register', 'KPBI\RegisterController@register');
Route::get('/register', 'KPBI\RegisterController@showRegisterForm')->name('register');

Route::group(['prefix' => 'my-profile', 'as' => 'profile'], function () {
    Route::get('/', 'DashboardController@myProfile');
    Route::post('/', 'DashboardController@saveProfile')->name(':update');
});

Route::group(['prefix' => 'my-account', 'as' => 'account'], function () {
    Route::get('/', 'DashboardController@myAccount');
    Route::post('/change-password', 'DashboardController@changePassword')->name(':change-password');
});


Route::get('/{vue_capture?}', function () {
    return view('vue.app');
})->where('vue_capture', '[\/\w\.-]*');
