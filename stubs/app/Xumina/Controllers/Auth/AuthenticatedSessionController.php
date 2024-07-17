<?php

namespace App\Xumina\{{ $panel }}\Controllers\Auth;

use App\Xumina\{{ $panel }}\Requests\Auth\LoginRequest;
use App\Xumina\{{ $panel }}\Pages\Auth\Login;
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
    public function create(Login $page): Response
    {
        return Inertia::render('{{ $inertia }}auth/login', [
            'canResetPassword' => Route::has('{{ $route }}password.request'),
            'status' => session('status'),
            'data' => $page->data(),
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
