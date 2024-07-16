<?php

namespace Hasnayeen\Xumina\Components\Concerns;

trait HasCssClass
{
    protected string $class = '';

    public function class(string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
