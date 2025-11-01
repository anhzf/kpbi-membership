<?php

use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipRequestController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\V2\AdminController as V2AdminController;
use App\Http\Controllers\V2\MembershipController as V2MembershipController;
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

Route::any('/', [UtilityController::class, 'index']);

Route::group([
    'middleware' => [
        'auth.basic',
        'require.user.role',
    ],
], function () {
    Route::get('/$dir', [UtilityController::class, 'listDirectory']);
    Route::get('/$env', [UtilityController::class, 'getEnvironment']);
    Route::get('/$cfg', [UtilityController::class, 'getConfig']);
    Route::get('/$db', [UtilityController::class, 'getDatabaseConfig']);
});

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::prefix('/auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [AuthController::class, 'store']);
    Route::delete('/', [AuthController::class, 'destroy']);
});

Route::prefix('/tokens')->group(function () {
    Route::get('/', [AuthController::class, 'listTokens'])->middleware('auth:sanctum');
    Route::post('/', [AuthController::class, 'createToken']);
    Route::delete('/', [AuthController::class, 'revokeAllTokens'])->middleware('auth:sanctum');
    Route::delete('/{token}', [AuthController::class, 'revokeToken'])->middleware('auth:sanctum');
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
Route::post('/member/{member}/bill', [MembershipController::class, 'bill']);
Route::apiResource('/course', CourseController::class);
Route::apiResource('/membership', MembershipRequestController::class);
Route::get('/membership/{membership}/request', [MembershipController::class, 'listRequest']);
Route::get('/membership-request/{membershipRequest}/invoice', [MembershipRequestController::class, 'showInvoice']);
Route::apiResource('/invoice', InvoiceController::class);
Route::get('/invoice/{invoice}/document/payload', [InvoiceController::class, 'showDocumentPayload']);
Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/documents/{document}', [DocumentController::class, 'show']);
Route::put('/documents/{document}', [DocumentController::class, 'update'])->middleware('auth:sanctum');
Route::apiResource('/accreditation', AccreditationController::class);

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/user', [AdminController::class, 'listUsers']);
    Route::put('/user/{user}/role', [AdminController::class, 'setUserRole']);

    Route::get('/membership-request', [AdminController::class, 'membershipRequestList']);
    Route::put('/membership-request/{membershipRequest}', [AdminController::class, 'membershipRequestApprove']);
});

Route::group([
    'prefix' => '/v2',
    'as' => 'v2.',
], function () {
    Route::get('/', [UtilityController::class, 'index']);

    Route::apiResource('/memberships', V2MembershipController::class);
    Route::get('/memberships/{membership}/invoices', [MembershipController::class, 'listInvoice']);

    Route::group([
        'prefix' => '/admin',
        'as' => 'admin.',
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/membership-requests-states', [V2AdminController::class, 'getMembershipRequestStates']);
        Route::patch('/invoices/{invoice}/membership-request', [V2AdminController::class, 'attachMembershipRequestToInvoice']);
    });
});
