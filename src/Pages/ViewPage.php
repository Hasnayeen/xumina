<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Actions\DeleteAction;
use Hasnayeen\Xumina\Components\Concerns\CanDeleteResource;
use Hasnayeen\Xumina\Components\Concerns\HasRecord;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;
use Illuminate\Support\Str;

class ViewPage extends Page
{
    use CanDeleteResource;
    use HasRecord;

    public function outline(): array
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
                'text' => 'View',
                'url' => static::getNavigationRoute($this->getRecord()),
            ],
        ];
    }

    public static function routes(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return 'View '.static::getModelName();
    }

    public static function getNavigationRoute(mixed $record = null): string
    {
        if ($record) {
            return route(static::getNavigationRouteName(), [
                Str::kebab(static::getModelName()) => $record,
            ]);
        }
        throw new \Exception('Record is required to generate route');
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.
            Str::kebab(Xumina::getCurrentPanel()->getName()).
            '.'.
            Str::kebab(static::getResourceName()).
            '.show';
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
            DeleteAction::make(
                Str::kebab('Delete '.static::getModelName())
            )->url(
                route(
                    'xumina.'.
                        Str::kebab(Xumina::getCurrentPanel()->getName()).
                        '.'.
                        Str::kebab(static::getResourceName()).
                        '.destroy',
                    [
                        Str::kebab(
                            static::getModelName()
                        ) => $this->getRecord(),
                    ]
                )
            ),
        ];
    }
}
