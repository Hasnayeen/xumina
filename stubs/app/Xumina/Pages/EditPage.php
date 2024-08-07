<?php

namespace App\Xumina\{{ $panel }}\Pages\{{ $resource }};

use {{ $modelFqcn }};
use {{ $resourceFqcn }};
use App\Xumina\{{ $panel }}\Controllers\{{ $model }}Controller;
use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Pages\EditPage;
use Illuminate\Support\Facades\Route;

class Edit{{ $model }} extends EditPage
{
    protected static string | null $model = {{ $model }}::class;
    protected static string | null $resource = {{ $resource }}::class;
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
            Route::get('{{ $resourceKebab }}/{{{ $modelKebab }}}/edit', [{{ $model }}Controller::class, 'edit'])
                ->name('{{ $resourceKebab }}.edit'),
            Route::put('{{ $resourceKebab }}/{{{ $modelKebab }}}', [{{ $model }}Controller::class, 'update'])
                ->name('{{ $resourceKebab }}.update'),
        ];
    }
}
