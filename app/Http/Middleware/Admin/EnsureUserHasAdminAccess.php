<?php

namespace App\Http\Middleware\Admin;

use App\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminAccess
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user instanceof User) {
            throw new AuthenticationException;
        }

        if (! $user->activo) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Su cuenta está inactiva o no tiene acceso al panel.']);
        }

        abort_unless($user->canAccessAdmin(), 403);
        abort_if($roles !== [] && ! $user->hasRole(...$roles), 403);

        return $next($request);
    }
}
