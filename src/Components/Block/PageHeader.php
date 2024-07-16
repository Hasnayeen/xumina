<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Action;
use Hasnayeen\Xumina\Enums\BlockType;
use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Support\Str;

class PageHeader
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
            'type' => BlockType::PageHeader->value,
            'data' => [
                'actions' => array_map(fn (Action $action) => $action->toArray(), Xumina::getCurrentPanel()->getCurrentPage()->getPageHeaderActions()),
            ],
        ];
    }
}
