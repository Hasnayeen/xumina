<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Radio
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected array $options = [],
        protected ?string $label = null,
        protected ?string $value = null
    ) {}

    public static function make(string $name): static
    {
        return new self($name);
    }

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function default(string $value): static
    {
        $this->value = $value;

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
                    'type' => 'radio',
                    'options' => $this->options,
                    'value' => $this->value,
                ],
            ],
        ];
    }
}
