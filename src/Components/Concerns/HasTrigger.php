<?php

namespace Hasnayeen\Xumina\Components\Concerns;

use Exception;

trait HasTrigger
{
    protected bool $trigger = true;

    protected string $triggerVariant = 'default';

    protected string $triggerSize = 'default';

    public function trigger(bool $condition): static
    {
        $this->trigger = $condition;

        return $this;
    }

    public function triggerVariant(string $variant): static
    {
        $this->triggerVariant = match ($variant) {
            'default', 'destructive', 'outline', 'ghost', 'link' => $variant,
            default => throw new Exception("Unknown variant named {$variant}"),
        };

        return $this;
    }

    public function triggerSize(string $size): static
    {
        $this->triggerSize = match ($size) {
            'default', 'sm', 'lg', 'icon' => $size,
            default => throw new Exception("Unknown size named {$size}"),
        };

        return $this;
    }
}
