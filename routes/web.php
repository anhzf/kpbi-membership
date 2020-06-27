<?php

use App\KPBI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('memberList');
});

Auth::routes([
    'register' => false,
    'verify' => true,
]);


Route::get('/members', 'DashboardController@members')->name('memberList');
Route::post('/register', 'KPBI\RegisterController@register');
Route::get('/register', 'KPBI\RegisterController@showRegisterForm')->name('register');
Route::group(['prefix' => 'my-profile', 'as' => 'profile'], function() {

    Route::get('/', 'DashboardController@myProfile');
    Route::post('/', 'DashboardController@saveProfile')->name(':update');

});
Route::group(['prefix' => 'my-account', 'as' => 'account'], function() {

    Route::get('/', 'DashboardController@myAccount');
    Route::post('/change-password', 'DashboardController@changePassword')->name(':change-password');

});


Route::get('/home', 'HomeController@index')->name('home');

// Route::any('/404', return)
