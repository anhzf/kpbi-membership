<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    VerifyEmail::toMailUsing(
      function (User $notifiable, $url) {
        $profile = $notifiable->kpbiProfile;

        return (new MailMessage)
          ->subject(__('Verifikasi Email Anda'))
          ->greeting(__('Hai, :name!', ['name' => $profile->username]))
          ->line(__('Username dan Password anda adalah sebagai berikut:'))
          ->line(__('Username: ') . $profile->username)
          ->line(__('Password: ') . $profile->username)
          ->line(__('Mohon klik tombol berikut untuk verifikasi email anda.'))
          ->action(__('Verifikasi'), $url)
          ->line(__('*Jika anda tidak meminta verifikasi email, maka tidak perlu melakukan apa pun.'))
          ->salutation(__('Terima kasih, KPBI'));
      }
    );
  }
}
