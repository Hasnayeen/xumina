<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Separator
{
    private function __construct(
        protected string $id,
    ) {}

    public static function make(): static
    {
        return new self(Str::ulid());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Separator->value,
            'data' => [],
        ];
    }
}
