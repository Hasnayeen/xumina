<?php

namespace App\Xumina\{{ $panel }}\Resources;

use Hasnayeen\Xumina\Resource;

class {{ $model }} extends Resource
{
    public static function getPanelName(): string
    {
        return '{{ $panel }}';
    }

    public static function getResourceName(): string
    {
        return '{{ $name }}';
    }

    public static function getNavigationLabel(): string
    {
        return '{{ $modelHeadline }}';
    }

    public static function getNavigationIcon(): string
    {
        return 'package';
    }
}
