<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Badge
{
    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $label = null,
    ) {}

    public static function make(?string $name = null): static
    {
        return new self(Str::ulid(), $name);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Badge->value,
            'data' => [
                'name' => $this->name,
                'type' => 'string',
                'label' => $this->label,
            ],
        ];
    }
}
