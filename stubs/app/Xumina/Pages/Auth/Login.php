<?php

namespace App\Xumina\{{ $name }}\Pages\Auth;

use App\Xumina\{{ $name }}\Controllers\Auth\AuthenticatedSessionController;
use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Components\Form\Input;
use Hasnayeen\Xumina\Components\Section;
use Hasnayeen\Xumina\Pages\AuthPage;
use Illuminate\Support\Facades\Route;

class Login extends AuthPage
{
    protected static string | null $title = 'Login';

    public function outline(): array
    {
        return [
            Section::make('login')
                ->items([
                    Form::make('login')
                        ->fields([
                            Input::make('email')
                                ->type('email'),
                            Input::make('password')
                                ->type('password'),
                        ])
                        ->submitButtonLabel('Login')
                ])
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('auth.login'),
            Route::post('login', [AuthenticatedSessionController::class, 'store'])
                ->name('auth.login.store'),
            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('auth.logout'),
        ];
    }
}
