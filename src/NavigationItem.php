<?php

namespace Hasnayeen\Xumina;

class NavigationItem
{
    protected string $label;

    protected string $url;

    protected ?string $icon = null;

    protected ?string $badge = null;

    protected bool $active;

    protected int $order;

    public static function make(): static
    {
        return new self;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function icon(?string $icon = null): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function badge(?string $badge = null): static
    {
        $this->badge = $badge;

        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function active(bool $condition): static
    {
        $this->active = $condition;

        return $this;
    }

    public function order(int $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
            'icon' => $this->icon ?? null,
            'badge' => $this->badge ?? null,
            'active' => $this->active ?? null,
            'order' => $this->order ?? 0,
        ];
    }
}
