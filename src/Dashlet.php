<?php

namespace Hasnayeen\Xumina;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

abstract class Dashlet
{
    private function __construct(
        protected string $id,
        protected string $name,
    ) {}

    public static function make(string $name): static
    {
        return new self(Str::ulid(), $name);
    }

    abstract public function outline(): array;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Dashlet->value,
            'data' => [
                'items' => array_map(fn ($component) => $component->toArray(), $this->outline()),
            ],
        ];
    }
}
