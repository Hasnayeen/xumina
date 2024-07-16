<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;

class AuthPage extends Page
{
    public function outline(): array
    {
        return [];
    }

    public function layout(): array
    {
        return $this->layout->outline(Xumina::getCurrentPanel()->getAuthLayout()->outline());
    }

    public static function routes(): array
    {
        return [];
    }
}
