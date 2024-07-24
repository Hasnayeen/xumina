<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Action;
use Hasnayeen\Xumina\Components\Concerns\HasTrigger;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class ThemeSwitcher
{
    use HasTrigger;

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
            Action::make('logout')
                ->icon('user'),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::ThemeSwitcher->value,
            'data' => [
                'content' => array_map(fn ($item) => $item->toArray(), $this->items()),
                'trigger' => $this->trigger,
                'triggerVariant' => $this->triggerVariant,
                'triggerSize' => $this->triggerSize,
            ],
        ];
    }
}
