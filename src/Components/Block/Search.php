<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Search
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
            'type' => ComponentType::Search->value,
            'data' => []
        ];
    }
}
