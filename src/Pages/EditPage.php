<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Concerns\HasRecord;
use Hasnayeen\Xumina\Components\Form\Concerns\HasForm;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;
use Illuminate\Support\Str;

class EditPage extends Page
{
    use HasForm;
    use HasRecord;

    public function outline(): array
    {
        return [];
    }

    public static function routes(): array
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
                'text' => 'Edit',
                'url' => static::getNavigationRoute(),
            ],
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Edit'.static::getModelName();
    }

    public static function getNavigationRoute(): string
    {
        return '';
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.edit';
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
