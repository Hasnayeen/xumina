<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Input
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected ?string $label = null,
        protected string $type = 'text',
        protected mixed $value = null,
        protected bool $floating = false,
    ) {}

    public static function make(string $name): static
    {
        return new self($name);
    }

    public function columnSpan(): static
    {
        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label ?? Str::headline($this->name);
    }

    public function default(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function floating(?bool $condition = true): static
    {
        $this->floating = $condition;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => Str::ulid(),
            'type' => ComponentType::Field->value,
            'data' => [
                'attributes' => [
                    'name' => $this->name,
                    'label' => $this->getLabel(),
                    'type' => $this->type,
                    'value' => $this->value ?? '',
                    'floating' => $this->floating,
                ],
            ],
        ];
    }
}
