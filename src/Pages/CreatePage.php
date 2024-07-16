<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Form\Concerns\HasForm;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;
use Illuminate\Support\Str;

class CreatePage extends Page
{
    use HasForm;

    public function outline(): array
    {
        return [];
    }

    public function breadcrumb(): array
    {
        return [
            ...parent::breadcrumb(),
            [
                'text' => $resource = static::getResourceName(),
                'url' => route('xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab($resource).'.index'),
            ],
            [
                'text' => 'Create',
                'url' => route('xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab($resource).'.'.'create'),
            ],
        ];
    }

    public static function routes(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return 'Create '.static::getResourceName();
    }

    public static function getNavigationRoute(): string
    {
        return route(static::getNavigationRouteName());
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.create';
    }

    public static function getNavigationOrder(): int
    {
        return 0;
    }

    public static function showInNavigation(): bool
    {
        return false;
    }

    public static function isNavigationActive(): bool
    {
        return false;
    }
}
