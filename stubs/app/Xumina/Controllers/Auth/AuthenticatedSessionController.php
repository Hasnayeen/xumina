<?php

namespace App\Xumina\{{ $panel }}\Controllers\Auth;

use App\Xumina\{{ $panel }}\Controllers\Controller;
use App\Xumina\{{ $panel }}\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('{{ $inertia }}Auth/Login', [
            'canResetPassword' => Route::has('{{ $route }}password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('{{ $route }}dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
