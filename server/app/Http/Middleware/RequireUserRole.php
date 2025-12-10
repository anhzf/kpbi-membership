<?php

namespace App\Http\Middleware;

use App\Models\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class RequireUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403, 'User does not have a role assigned');
        }

        // If no specific roles provided, just check that user has any role
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user's role matches any of the allowed roles
        if (!in_array($user->role->value, $roles)) {
            abort(403, 'User does not have required role');
        }

        return $next($request);
    }
}
