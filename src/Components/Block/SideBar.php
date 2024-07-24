<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Logo;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class SideBar
{
    private function __construct(
        protected string $id,
    ) {}

    public static function make(): static
    {
        return new self(Str::ulid());
    }

    public function items(): array
    {
        return [
            Container::make()
                ->class('flex h-full max-h-screen flex-col gap-2')
                ->items([
                    Container::make()
                        ->class('flex justify-between h-14 items-center border-b px-4 lg:h-[60px] lg:px-6')
                        ->items([
                            Logo::make(),
                            Notification::make()
                                ->triggerVariant('outline')
                                ->triggerSize('icon'),
                        ]),
                    Container::make()
                        ->class('flex-1')
                        ->items([
                            Navigation::make()
                                ->class('grid items-start px-2 text-sm font-medium'),
                        ]),
                ]),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Container->value,
            'data' => [
                'tag' => 'aside',
                'className' => 'inset-y fixed left-0 z-20 h-full flex-col border-r w-64 hidden md:flex bg-muted/40',
                'items' => array_map(fn ($item) => $item->toArray(), $this->items()),
            ],
        ];
    }
}
