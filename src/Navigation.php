<?php

namespace Hasnayeen\Xumina;

class Navigation
{
    protected array $items = [];

    public static function make(): static
    {
        return new self;
    }

    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(string $key, NavigationItem $item): static
    {
        $this->items[$key][] = $item;

        return $this;
    }

    public function toArray(): array
    {
        return array_map(fn ($item) => $item->toArray(), $this->items);
    }
}
