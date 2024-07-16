<?php

namespace Hasnayeen\Xumina\Layouts;

use Hasnayeen\Xumina\Components\Block\Container;
use Hasnayeen\Xumina\Components\Block\Content;
use Hasnayeen\Xumina\Contracts\Layout;

class AuthLayout implements Layout
{
    public function outline(): array
    {
        return [
            Container::make()
                ->class('flex min-h-screen items-center justify-center')
                ->items([
                    Container::make()
                        ->class('w-full max-w-md')
                        ->items([
                            Content::make(),
                        ]),
                ]),
        ];
    }
}
