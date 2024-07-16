<?php

namespace Hasnayeen\Xumina\Components\Form;

use Hasnayeen\Xumina\Components\Form\Concerns\HasRules;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class FileUpload
{
    use HasRules;

    private function __construct(
        protected string $name,
        protected ?string $label = null,
        protected ?array $accept = null,
        protected bool $multiple = false
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

    public function accept(array $mimeTypes): static
    {
        $this->accept = $mimeTypes;

        return $this;
    }

    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;

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
                    'accept' => $this->accept,
                    'multiple' => $this->multiple,
                    'type' => 'fileupload',
                ],
            ],
        ];
    }
}
