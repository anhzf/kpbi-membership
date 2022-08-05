<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends APIController
{
  public function whoami()
  {
    return $this->send(Auth::user());
  }

  public function login(Request $request)
  {
    $credential = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt($credential)) {
      $request->session()->regenerate();
      return $this->send(['cred' => $request->user()]);
    }

    return $this->sendError('INVALID_CREDENTIALS', 401);
  }

  public function verifyVerification(EmailVerificationRequest $request)
  {
    $request->fulfill();
    return $this->send(null, __('Verifikasi berhasil!'));
  }

  public function logout(Request $request)
  {
    $request->session()->invalidate();
    $request->session()->regenerateToken();
  }
}
