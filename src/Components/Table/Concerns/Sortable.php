<?php

namespace Hasnayeen\Xumina\Components\Table\Concerns;

trait Sortable
{
    protected bool $sortable = false;

    public function sortable(bool $condition = true): static
    {
        $this->sortable = $condition;

        return $this;
    }
}
