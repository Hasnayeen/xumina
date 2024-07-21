<?php

namespace App\Xumina\{{ $panel }}\Resources;

use Hasnayeen\Xumina\Resource;

class {{ $name }} extends Resource
{
    public static function getPanelName(): string
    {
        return '{{ $panel }}';
    }

    public static function getResourceName(): string
    {
        return '{{ $name }}';
    }

    public static function getModelName(): string
    {
        return '{{ $modelFqcn }}';
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
