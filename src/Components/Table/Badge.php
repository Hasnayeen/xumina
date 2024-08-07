<?php

namespace Hasnayeen\Xumina\Components\Table;

use Hasnayeen\Xumina\Components\Table\Concerns\HasRelation;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Badge
{
    use HasRelation;

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
                'variant' => 'default',
                'type' => 'string',
                'relation' => $this->relation,
                'label' => $this->label,
            ],
        ];
    }
}
