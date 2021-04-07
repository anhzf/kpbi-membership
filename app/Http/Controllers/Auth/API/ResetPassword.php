<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ResetPassword extends Controller
{
  public function __construct()
  {
    $this->middleware('signed');
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    // Get user
    $users = User::where('email', $request->email)->get();
    $user = $users->filter(function ($user) use ($request) {
      return hash_equals($request->route('username'), sha1($user->name));
    })->first();

    // Change password
    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json([
      'success' => true,
      'message' => 'Password berhasil diubah!'
    ]);
  }

  private function validateRequest(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'token' => [
        'required',
        Rule::exists('password_resets', 'token')
      ]
    ]);

    if (!hash_equals($request->hash, sha1($request->email)))
      throw new AuthorizationException;
  }
}
