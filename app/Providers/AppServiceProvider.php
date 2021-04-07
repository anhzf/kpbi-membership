<?php

namespace App\Providers;

use App\User;
use App\Mail\RegisterKPBI;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // Override the email notification for verifying email
    VerifyEmail::toMailUsing(function (User $notifiable) {
      $verifyUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
          'id' => $notifiable->getKey(),
          'hash' => sha1($notifiable->getEmailForVerification()),
        ]);

      if (is_null($user_profile = $notifiable->kpbi_profile)) {
        Auth::logout();

        $notifiable->delete();

        return response()->json([
          'success' => false,
          'message' => 'Anda belum terdaftar sebagai anggota'
        ], 401);
      }

      return (new RegisterKPBI($verifyUrl, $notifiable))
        ->subject(__('kpbi.mail.subject'))
        ->view('email.RegisterKPBI')
        ->to($notifiable->email);
    });
  }
}
