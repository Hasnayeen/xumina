<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Action
{
    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $label = null,
        protected bool $asButton = true,
        protected bool $asLink = false,
        protected ?string $url = null,
        protected ?string $action = null,
        protected bool $requireConfirmation = false,
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

    public function asButton(bool $condition): static
    {
        $this->asButton = $condition;
        $this->asLink = ! $condition;

        return $this;
    }

    public function asLink(bool $condition): static
    {
        $this->asLink = $condition;
        $this->asButton = ! $condition;

        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function action(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function requireConfirmation(bool $condition = true): static
    {
        $this->requireConfirmation = $condition;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Action->value,
            'data' => [
                'label' => $this->label ?? Str::headline($this->name) ?? null,
                'url' => $this->url,
                'asButton' => $this->asButton,
                'asLink' => $this->asLink,
                'action' => $this->action,
                'requireConfirmation' => $this->requireConfirmation,
            ],
        ];
    }
}
