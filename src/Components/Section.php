<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Components\Form\Concerns\HasColumnSpan;
use Hasnayeen\Xumina\Components\Form\Concerns\HasGridColumns;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Section
{
    use HasColumnSpan;
    use HasGridColumns;

    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $description = null,
        protected array $items = [],
    ) {}

    public static function make(?string $name = null): static
    {
        return new self(Str::ulid(), $name);
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function columns(int $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Section->value,
            'data' => [
                'title' => Str::headline($this->name) ?? null,
                'description' => $this->description ?? null,
                'items' => array_map(fn ($item) => $item->toArray(), $this->items),
                'columns' => $this->columns ?? 1,
            ],
        ];
    }
}
