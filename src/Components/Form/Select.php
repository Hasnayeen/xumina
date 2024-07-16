<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Select
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected array $options = [],
        protected ?string $label = null,
        protected mixed $value = null,
        protected bool $multiple = false,
        protected ?string $placeholder = null,
        protected ?array $relationship = null,
        protected ?Model $model = null,
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

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function relationship(string $modelClass, string $value, string $label): static
    {
        $this->relationship = [
            'model' => $modelClass,
            'value' => $value,
            'label' => $label,
        ];

        $this->model = app($modelClass);

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

    public function default(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function multiple(bool $condition = true): static
    {
        $this->multiple = $condition;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    protected function loadOptions(): array
    {
        if (! $this->relationship || ! $this->model) {
            return $this->options;
        }

        return $this->model::select([$this->relationship['value'], $this->relationship['label']])
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->{$this->relationship['value']},
                    'label' => $item->{$this->relationship['label']},
                ];
            })
            ->toArray();
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
                    'type' => 'select',
                    'options' => $this->loadOptions(),
                    'value' => $this->value ?? '',
                    'multiple' => $this->multiple,
                    'placeholder' => $this->placeholder,
                ],
            ],
        ];
    }
}
