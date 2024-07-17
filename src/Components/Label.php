<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Label
{
    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $body = null,
        protected ?int $limit = null,
    ) {}

    public static function make(?string $name = null): static
    {
        return new self(Str::ulid(), $name);
    }

    public function body(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Label->value,
            'data' => [
                'name' => $this->name,
                'type' => 'string',
                'body' => $this->body,
                'limit' => $this->limit,
            ],
        ];
    }
}
