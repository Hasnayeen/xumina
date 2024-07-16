<?php

namespace Hasnayeen\Xumina\Components;

use Illuminate\Support\Facades\Blade;

class Icon
{
    public static function get(string $name, ?string $class = 'w-4 h-4'): string
    {
        return Blade::render("<x-lucide-{$name} class=\"{$class}\" />");
    }
}
