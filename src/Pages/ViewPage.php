<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Action;
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

    public static function routes(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return 'View '.static::getModelName();
    }

    public static function getNavigationRoute(): string
    {
        return '';
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.show';
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
            Action::make(Str::kebab('Delete '.static::getModelName()))
                ->label('Delete')
                ->asButton()
                ->url(
                    route(
                        'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.destroy',
                        [Str::kebab(static::getModelName()) => $this->getRecord()],
                    )
                ),
        ];
    }
}
