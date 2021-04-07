<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BasicController extends Controller
{
  /**
   * Login user and create token
   *
   * @param  String $email
   * @param  String $password
   * @param  Boolean $remember_me
   * @return String $access_token
   * @return String $token_type
   * @return String $expires_at
   */
  public function login(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'password' => 'required|string',
      'remember_me' => 'boolean'
    ]);
    $credentials = request(['name', 'password']);
    if (!Auth::attempt($credentials))
      return response()->json([
      'success' => false,
      'message' => 'Mohon maaf, username/password salah!'
      ], 401);
    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->token;
    if ($request->remember_me)
      $token->expires_at = Carbon::now()->addWeeks(1);
    $token->save();
    return response()->json([
      'success' => true,
      'access_token' => $tokenResult->accessToken,
      'token_type' => 'Bearer',
      'expires_at' => Carbon::parse(
      $tokenResult->token->expires_at
      )->toDateTimeString()
    ]);
  }

  /**
   * Logout user (Revoke the token)
   *
   * @return String message
   */
  public function logout(Request $request)
  {
    $request->user()->token()->revoke();
    return response()->json([
      'message' => 'Successfully logged out'
    ]);
  }

  /**
   * Get the authenticated User
   *
   * @return [json] user object
   */
  public function user(Request $request)
  {
    $user = $request->user();
    return response()->json($user->toArray() + ['verified' => $user->hasVerifiedEmail()]);
  }

  /**
   * Change Password
   *
   * @return [json] user object
   */
  public function changePassword(Request $request)
  {
    $user = $request->user();
    $request->validate([
      'oldPassword' => 'required',
      'newPassword' => 'required|confirmed|min:6',
    ]);

    if (!Hash::check($request->get('oldPassword'), $user->password)) {
      return response()->json(
      [
        'success' => false,
        'message' => 'Password lama yang dimasukkan tidak cocok!'
      ],
      400
      );
    }

    $user->update([
      'password' => Hash::make($request->get('newPassword'))
    ]);

    if ($user->save()) {
      return response()->json(['success' => true, 'message' => __('Password berhasil diubah!')]);
    }

    return response()->json(['success' => false, 'message' => __('Error! Terjadi kesalahan!')], 400);
  }
}
