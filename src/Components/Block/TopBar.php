<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class TopBar
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
            MobileNavigation::make(),
            Container::make()
                ->class('w-full flex-1')
                ->items([
                    Search::make(),
                ]),
            ThemeSwitcher::make()
                ->triggerVariant('outline')
                ->triggerSize('icon'),
            UserMenu::make()
                ->triggerVariant('outline')
                ->triggerSize('icon'),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Container->value,
            'data' => [
                'tag' => 'header',
                'className' => 'flex h-14 items-center gap-4 border-b bg-muted/40 px-4 lg:h-[60px] lg:px-6',
                'items' => array_map(fn ($item) => $item->toArray(), $this->items()),
            ],
        ];
    }
}
