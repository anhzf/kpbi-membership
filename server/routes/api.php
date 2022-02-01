<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KpbiProfileController;
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

Route::get('/', fn () => response()->json('Welcome to Kpbi API!'));

Route::prefix('/auth')->group(function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyVerification'])
    ->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
});

Route::apiResource('/kpbi-profile', KpbiProfileController::class);

Route::middleware(['auth:sanctum'])->group(function () {
  Route::prefix('/iam')->group(function () {
    Route::get('/', [AuthController::class, 'whoami']);
    Route::get('/kpbi-profile', [KpbiProfileController::class, 'showIam']);
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});
