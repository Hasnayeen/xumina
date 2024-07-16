<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Enums\BlockType;
use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Support\Str;

class SideBar
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
            'type' => BlockType::SideBar->value,
            'data' => [
                'logo' => Xumina::getCurrentPanel()->getLogo(),
            ],
        ];
    }
}
