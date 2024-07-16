<?php

namespace Hasnayeen\Xumina\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Hasnayeen\Xumina\Panel getPanel(string $name)
 * @method static \Hasnayeen\Xumina\Panel getCurrentPanel()
 * @method static array share(Request $request)
 * @method static \Illuminate\Support\Collection getPanels()
 *
 * @see \Hasnayeen\Xumina\Xumina
 */
class Xumina extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'xumina';
    }
}
