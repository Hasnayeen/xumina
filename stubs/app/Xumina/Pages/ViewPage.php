<?php

namespace App\Xumina\{{ $panel }}\Pages\{{ $resource }};

use {{ $modelFqcn }};
use App\Xumina\{{ $panel }}\Controllers\{{ $model }}Controller;
use Hasnayeen\Xumina\Pages\ViewPage;
use Illuminate\Support\Facades\Route;

class View{{ $model }} extends ViewPage
{
    protected static string | null $model = {{ $model }}::class;
    protected static string | null $resource = '{{ $resource }}';
    protected static string | null $title = 'View {{ $model }}';

    public function outline(): array
    {
        return [
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('{{ $resourceKebab }}/{{{ $modelKebab }}}', [{{ $model }}Controller::class, 'show'])
                ->name('{{ $resourceKebab }}.show'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'View ' . static::getModelName();
    }

    public static function getNavigationRoute(): string
    {
        return route('xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'{'.Str::kebab(static::getModelName()).'}.show');
    }
}
