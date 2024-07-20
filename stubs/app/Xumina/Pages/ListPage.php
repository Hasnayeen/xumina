<?php

namespace App\Xumina\{{ $panel }}\Pages\{{ $resource }};

use {{ $modelFqcn }};
use {{ $resourceFqcn }};
use App\Xumina\{{ $panel }}\Controllers\{{ $model }}Controller;
use Hasnayeen\Xumina\Components\Table;
use Hasnayeen\Xumina\Pages\ListPage;
use Illuminate\Support\Facades\Route;

class List{{ $model }} extends ListPage
{
    protected static string | null $model = {{ $model }}::class;
    protected static string | null $resource = {{ $resource }}::class;
    protected static string | null $title = '{{ $resource }}';

    public function outline(): array
    {
        return [
            Table::make('{{ $resourceKebab }}')
                ->model($this->getModel())
                ->columns([])
        ];
    }

    public static function routes(): array
    {
        return [
            Route::get('{{ $resourceKebab }}', [{{ $model }}Controller::class, 'index'])
                ->name('{{ $resourceKebab }}.index'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'List {{ $resource }}';
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.{{ $panelKebab }}.{{ $resourceKebab }}.index';
    }
}
