<?php

namespace App\Xumina\{{ $panel }}\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('{{ $route }}dashboard', absolute: false))
                    : Inertia::render('{{ $inertia }}/auth/verify-email', ['status' => session('status')]);
    }
}
