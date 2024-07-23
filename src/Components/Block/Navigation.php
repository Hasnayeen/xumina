<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Concerns\HasCssClass;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Navigation
{
    use HasCssClass;

    private function __construct(
        protected string $id,
        protected string $name = 'primary',
    ) {}

    public static function make(): static
    {
        return new self(Str::ulid());
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Navigation->value,
            'data' => [
                'name' => $this->name,
                'className' => $this->class,
            ],
        ];
    }
}
