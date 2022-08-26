<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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

Route::get('/', fn () => response()->json('ready!'));

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::prefix('/auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [AuthController::class, 'store']);
    Route::delete('/', [AuthController::class, 'destroy']);
});

Route::apiResource('/members', MembershipController::class);
