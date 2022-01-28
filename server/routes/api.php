<?php

use App\Http\Controllers\AuthController;
use App\Models\KpbiProfile;
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

Route::get('/', function (Request $request) {
  /** @var KpbiProfile */
  $profile = KpbiProfile::with([
    'user',
    'perguruanTinggi',
    'kaprodi',
    'akreditasiProdi',
  ])->find(5);

  return response()->json($profile);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/user', [AuthController::class, 'whoami']);
});
