<?php

use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipRequestController;
use App\Http\Controllers\VerificationController;
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

Route::any('/', fn () => response()->json('ready!'));

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::prefix('/auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [AuthController::class, 'store']);
    Route::delete('/', [AuthController::class, 'destroy']);
});

Route::group([
    'prefix' => '/me',
    'middleware' => 'auth:sanctum',
], function () {
    Route::put('/', [MeController::class, 'update']);
});

Route::prefix('/user')->group(function () {
    Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])
        ->name('password.reset');
    Route::put('/change-password', [AuthController::class, 'changePassword'])
        ->name('password.change');

    Route::group([
        'prefix' => 'verify',
        'as' => 'verification.',
    ], function () {
        Route::post('/{id}', [VerificationController::class, 'verify'])
            ->name('verify');
        Route::get('/resend', [VerificationController::class, 'resend'])
            ->name('resend');
    });
});

Route::get('/member/me', [MembershipController::class, 'showMy'])
    ->middleware('auth:sanctum');
Route::get('/member/{member}/document', [MembershipController::class, 'showCertificate']);
Route::apiResource('/member', MembershipController::class);
Route::apiResource('/membership', MembershipRequestController::class);
Route::apiResource('/course', CourseController::class);
Route::apiResource('/accreditation', AccreditationController::class);

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/membership', [AdminController::class, 'membershipRequestList']);
    Route::put('/membership/{membershipRequest}', [AdminController::class, 'membershipRequestApprove']);
});
