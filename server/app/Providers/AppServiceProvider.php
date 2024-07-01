<?php

namespace App\Providers;

use App\Models\User;
use App\Utils;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
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
            $handlerUrl = (object) parse_url(request('handler_url') ?? env('APP_URL'));
            $origin = Utils::buildOriginFromParsedUrl($handlerUrl);
            $query = [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ];
            parse_str($handlerUrl->query ?? '', $originQuery);
            $q = http_build_query([...$originQuery, ...$query]);
            return "{$origin}{$handlerUrl->path}?{$q}";
        });

        VerifyEmail::createUrlUsing(function (User $user) {
            $handlerUrl = (object) parse_url(request('handler_url') ?? env('APP_URL'));
            $handlerUrlPath = $handlerUrl->path ?? '';
            $origin = Utils::buildOriginFromParsedUrl($handlerUrl);
            $callbackUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );
            parse_str($handlerUrl->query ?? '', $originQuery);
            $q = http_build_query([
                ...$originQuery,
                'callback_url' => Utils::stripOrigin($callbackUrl),
            ]);
            return "{$origin}{$handlerUrlPath}?{$q}";
        });
    }
}
