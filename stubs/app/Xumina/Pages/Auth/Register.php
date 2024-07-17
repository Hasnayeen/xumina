<?php

namespace App\Xumina\{{ $panel }}\Pages\Auth;

use App\Xumina\{{ $panel }}\Controllers\Auth\RegisteredUserController;
use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Components\Form\Input;
use Hasnayeen\Xumina\Components\Section;
use Hasnayeen\Xumina\Pages\AuthPage;
use Illuminate\Support\Facades\Route;

class Register extends AuthPage
{
    protected static string | null $title = 'Register';

    public function outline(): array
    {
        return [
            Section::make('register')
                ->items([
                Form::make('register')
                    ->columns(1)
                    ->fields([
                        Input::make('name'),
                        Input::make('email')
                            ->type('email'),
                        Input::make('password')
                            ->type('password'),
                        Input::make('password_confirmation')
                            ->type('password'),
                    ])
                    ->submitTo('xumina.{{ $panelKebab }}.auth.register.store')
                    ->submitButtonLabel(__('Register'))
                    ->cancelButton(false)
            ])
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('auth.register'),
            Route::post('register', [RegisteredUserController::class, 'store'])
                ->name('auth.register.store'),
        ];
    }
}
