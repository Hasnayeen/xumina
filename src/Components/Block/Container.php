<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Concerns\HasCssClass;
use Hasnayeen\Xumina\Enums\BlockType;
use Illuminate\Support\Str;

class Container
{
    use HasCssClass;

    private function __construct(
        protected string $id,
        protected array $items = [],
    ) {}

    public static function make(): static
    {
        return new self(Str::ulid());
    }

    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => BlockType::Container->value,
            'data' => [
                'className' => $this->class,
                'items' => array_map(fn ($item) => $item->toArray(), $this->items),
            ],
        ];
    }
}
