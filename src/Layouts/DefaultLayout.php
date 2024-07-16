<?php

namespace Hasnayeen\Xumina\Layouts;

use Hasnayeen\Xumina\Components\Block\Breadcrumb;
use Hasnayeen\Xumina\Components\Block\Container;
use Hasnayeen\Xumina\Components\Block\Content;
use Hasnayeen\Xumina\Components\Block\PageHeader;
use Hasnayeen\Xumina\Components\Block\SideBar;
use Hasnayeen\Xumina\Components\Block\TopBar;
use Hasnayeen\Xumina\Contracts\Layout;

class DefaultLayout implements Layout
{
    public function outline(): array
    {
        return [
            Container::make()
                ->class('grid min-h-screen w-full md:pl-64')
                ->items([
                    SideBar::make(),
                    Container::make()
                        ->class('flex flex-col')
                        ->items([
                            TopBar::make(),
                            Container::make()
                                ->class('flex flex-1 flex-col gap-4 px-4 lg:gap-6 lg:px-6 py-4')
                                ->items([
                                    Breadcrumb::make(),
                                    PageHeader::make(),
                                    Content::make(),
                                ]),
                        ]),
                ]),
        ];
    }
}
