<?php

use App\Http\Api;
use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipRequestController;
use App\Http\Controllers\V2\AdminController as V2AdminController;
use App\Http\Controllers\V2\MembershipController as V2MembershipController;
use App\Http\Controllers\VerificationController;
use App\Models\MembershipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::any('/', fn() => Api::message('ready!'));

Route::group([
    'middleware' => [
        'auth.basic',
        fn(Request $request, \Closure $next) => auth()->user()?->role
            ? $next($request) : abort(403),
    ],
], function () {
    Route::get('/$dir', fn() => Api::data(scandir(base_path(request('path')))));
    Route::get('/$env', fn() => Api::data(request('key') ? env(request('key')) : getenv()));
    Route::get('/$cfg', fn() => Api::data(config(request('key'))));
    Route::get('/$db', fn() => Api::data(DB::connection()->getConfig()));
});

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
Route::post('/member/{member}/bill', [MembershipController::class, 'bill']);
Route::apiResource('/course', CourseController::class);
Route::apiResource('/membership', MembershipRequestController::class);
Route::get('/membership/{membership}/request', [MembershipController::class, 'listRequest']);
Route::get('/membership-request/{membershipRequest}/invoice', [MembershipRequestController::class, 'showInvoice']);
Route::apiResource('/invoice', InvoiceController::class);
Route::get('/invoice/{invoice}/document/payload', [InvoiceController::class, 'showDocumentPayload']);
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
    Route::get('/', fn () => Api::message('ready!'));

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
