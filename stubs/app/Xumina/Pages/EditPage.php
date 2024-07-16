<?php

namespace App\Xumina\{{ $panel }}\Pages\{{ $resource }};

use {{ $modelFqcn }};
use App\Xumina\{{ $panel }}\Controllers\{{ $model }}Controller;
use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Pages\CreatePage;
use Illuminate\Support\Facades\Route;

class Edit{{ $model }} extends EditPage
{
    protected static string | null $model = {{ $model }}::class;
    protected static string | null $resource = '{{ $resource }}';
    protected static string | null $title = 'Edit {{ $model }}';

    public function outline(): array
    {
        return [
            Form::make('{{ $resourceKebab }}')
                ->fields([])
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('{{ $resourceKebab }}/{{{ $modelKebab }}}/create', [{{ $model }}Controller::class, 'edit'])
                ->name('{{ $resourceKebab }}.edit'),
            Route::('{{ $resourceKebab }}', [{{ $model }}Controller::class, 'store'])
                ->name('{{ $resourceKebab }}.update'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Edit {{ $model }}';
    }

    public static function getNavigationRoute(): string
    {
        return route('xumina.{{ $panelKebab }}.{{ $resourceKebab }}.edit', ['{{ $modelKebab }}' => $this->getRecord()]);
    }
}
