<?php

namespace Hasnayeen\Xumina;

use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Support\Str;

abstract class Resource
{
    abstract public static function getPanelName(): string;

    abstract public static function getResourceName(): string;

    abstract public static function getNavigationLabel(): string;

    abstract public static function getNavigationIcon(): string;

    public static function getNavigationRoute(): string
    {
        return route(static::getNavigationRouteName());
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.Str::kebab(static::getResourceName()).'.index';
    }

    public static function getNavigationOrder(): int
    {
        return 1;
    }

    public static function showInNavigation(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    public static function isNavigationActive(): bool
    {
        return Str::startsWith(request()->route()->getName(), 'xumina.'.Str::kebab(static::getPanelName()).'.'.Str::kebab(static::getResourceName()));
    }
}
