<?php

namespace App\Providers;

use App\Models\User;
use App\Utils;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            $handlerUrl = (object) parse_url(request('handler_url'));
            $origin = Utils::buildOriginFromParsedUrl($handlerUrl);
            $query = [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ];
            parse_str($handlerUrl->query ?? '', $originQuery);
            $q = http_build_query([...$originQuery, ...$query]);
            return "{$origin}{$handlerUrl->path}?{$q}";
        });
    }
}
