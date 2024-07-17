<?php

namespace App\Xumina\{{ $panel }}\Pages\Auth;

use App\Xumina\{{ $panel }}\Controllers\Auth\AuthenticatedSessionController;
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
                        ->columns(1)
                        ->fields([
                            Input::make('email')
                                ->type('email'),
                            Input::make('password')
                                ->type('password'),
                        ])
                        ->submitTo('xumina.{{ $panelKebab }}.auth.login.store')
                        ->submitButtonLabel(__('Login'))
                        ->cancelButton(false)
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
