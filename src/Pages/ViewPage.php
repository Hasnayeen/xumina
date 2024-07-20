<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Concerns\CanDeleteResource;
use Hasnayeen\Xumina\Page;

class ViewPage extends Page
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
}
