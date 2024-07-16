<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class DatePicker
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected ?string $label = null,
        protected mixed $value = null,
        protected ?string $format = 'Y-m-d',
        protected ?string $placeholder = null
    ) {}

    public static function make(string $name): static
    {
        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
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

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

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
                    'value' => $this->value,
                    'format' => $this->format,
                    'placeholder' => $this->placeholder,
                    'type' => 'datepicker',
                ],
            ],
        ];
    }
}
