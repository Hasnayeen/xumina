<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Checkbox
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected ?string $label = null,
        protected bool $checked = false
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

    public function checked(bool $checked = true): static
    {
        $this->checked = $checked;

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
                    'type' => 'checkbox',
                    'checked' => $this->checked,
                ],
            ],
        ];
    }
}
