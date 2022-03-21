<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ForgotPassword extends Controller {
  private User $user;
  private $token;
  // use SendsPasswordResetEmails;

  public function __invoke(Request $request) {
    $this->validateRequest($request);

    $this->user = User::where('email', $request->email)->first();
    $this->token = $this->generateToken();

    DB::table('password_resets')->insert([
      'email' => $this->user->email,
      'token' => $this->token,
      'created_at' => now(),
    ]);

    $this->sendResetPasswordLink();

    return response()->json([
      'success' => true,
      'message' => 'email telah dikirim ke ' . $this->user->email,
    ]);
  }

  private function validateRequest(Request $request) {
    $request->validate([
      'email' => [
        'required', 'string', 'email',
        Rule::exists(User::class, 'email'),
      ],
    ]);
  }

  private function generateToken() {
    while (true) {
      $token = Str::random(72);
      $isTokenExist = DB::table('password_resets')
        ->where('token', $token)
        ->count();

      if (!$isTokenExist) {
        return $token;
      }
    }
  }

  private function sendResetPasswordLink() {
    $link = $this->generateResetPasswordLink();

    Mail::to($this->user->email)
      ->send(new ResetPassword($link));

    if (Mail::failures()) {
      return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan!',
      ], 400);
    }
  }

  protected function generateResetPasswordLink() {
    return URL::temporarySignedRoute('password.reset', now()->addDay(), [
      'hash' => sha1($this->user->email),
      'token' => $this->token,
      'username' => sha1($this->user->name),
    ]);
  }
}
