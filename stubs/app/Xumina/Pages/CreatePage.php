<?php

namespace App\Xumina\{{ $panel }}\Pages\{{ $resource }};

use {{ $modelFqcn }};
use {{ $resourceFqcn }};
use App\Xumina\{{ $panel }}\Controllers\{{ $model }}Controller;
use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Pages\CreatePage;
use Illuminate\Support\Facades\Route;

class Create{{ $model }} extends CreatePage
{
    protected static string | null $model = {{ $model }}::class;
    protected static string | null $resource = {{ $resource }}::class;
    protected static string | null $title = 'Create {{ $model }}';

    public function outline(): array
    {
        return [
            Form::make('{{ $modelKebab }}')
                ->fields([])
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('{{ $resourceKebab }}/create', [{{ $model }}Controller::class, 'create'])
                ->name('{{ $resourceKebab }}.create'),
            Route::post('{{ $resourceKebab }}', [{{ $model }}Controller::class, 'store'])
                ->name('{{ $resourceKebab }}.store'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Create ' . static::getResourceName();
    }

    public static function getNavigationRoute(): string
    {
        return route('xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.create');
    }
}
