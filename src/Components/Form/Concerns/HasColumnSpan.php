<?php

namespace Hasnayeen\Xumina\Components\Form\Concerns;

trait HasColumnSpan
{
    protected int $columnSpan;

    public function columnSpan(int $columnSpan): static
    {
        $this->columnSpan = $columnSpan;

        return $this;
    }

    public function columnSpanFull(): static
    {
        $this->columnSpan = 12;

        return $this;
    }
}
