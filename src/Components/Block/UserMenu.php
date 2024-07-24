<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Action;
use Hasnayeen\Xumina\Components\Concerns\HasTrigger;
use Hasnayeen\Xumina\Components\Label;
use Hasnayeen\Xumina\Components\Separator;
use Hasnayeen\Xumina\Enums\ComponentType;
use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Support\Str;

class UserMenu
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
            Label::make()
                ->body(auth()->user()->name),
            Separator::make(),
            Action::make('logout')
                ->icon('user')
                ->url(route('xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.auth.logout')),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::UserMenu->value,
            'data' => [
                'content' => array_map(fn ($item) => $item->toArray(), $this->items()),
                'trigger' => $this->trigger,
                'triggerVariant' => $this->triggerVariant,
                'triggerSize' => $this->triggerSize,
            ],
        ];
    }
}
