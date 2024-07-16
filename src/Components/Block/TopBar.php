<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Enums\BlockType;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => BlockType::TopBar->value,
            'data' => [
            ],
        ];
    }
}
