<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::user()?->canAccessAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Las credenciales no son válidas para el acceso administrativo.'])
                ->withInput($request->only('email'));
        }

        $user = Auth::user();

        if (! $user instanceof User || ! $user->canAccessAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Las credenciales no son válidas para el acceso administrativo.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
