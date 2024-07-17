<?php

namespace App\Xumina\{{ $panel }}\Controllers\{{ $panel }}\Auth;

use App\Xumina\{{ $panel }}\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('{{ $route }}dashboard', absolute: false))
                    : Inertia::render('{{ $inertia }}/Auth/VerifyEmail', ['status' => session('status')]);
    }
}
