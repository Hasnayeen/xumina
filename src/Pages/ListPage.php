<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Action;
use Hasnayeen\Xumina\Components\Concerns\CanDeleteResource;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;
use Illuminate\Support\Str;

class ListPage extends Page
{
    use CanDeleteResource;

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
                'text' => static::getResourceName(),
                'url' => $this->getResource()->getNavigationRoute(),
            ],
            [
                'text' => 'List',
                'url' => static::getNavigationRoute(),
            ],
        ];
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.
            Str::kebab(Xumina::getCurrentPanel()->getName()).
            '.'.
            Str::kebab(static::getResourceName()).
            '.index';
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

    public function getPageHeaderActions(): array
    {
        return [
            Action::make(Str::kebab('Create '.static::getModelName()))
                ->label('Create '.static::getModelName())
                ->asButton()
                ->url(
                    route(
                        'xumina.'.
                            Str::kebab(Xumina::getCurrentPanel()->getName()).
                            '.'.
                            Str::kebab(static::getResourceName()).
                            '.create'
                    )
                ),
        ];
    }
}
