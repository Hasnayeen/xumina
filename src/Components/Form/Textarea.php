<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Textarea
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected ?string $label = null,
        protected ?string $placeholder = null,
        protected ?string $value = null,
        protected int $rows = 3
    ) {}

    public static function make(string $name): static
    {
        return new self($name);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function default(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function rows(int $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label ?? Str::headline($this->name);
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
                    'type' => 'textarea',
                    'placeholder' => $this->placeholder,
                    'value' => $this->value,
                    'rows' => $this->rows,
                ],
            ],
        ];
    }
}
