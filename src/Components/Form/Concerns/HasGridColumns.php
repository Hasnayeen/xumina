<?php

namespace Hasnayeen\Xumina\Components\Form\Concerns;

trait HasGridColumns
{
    protected int $columns;

    public function columns(int $columns): static
    {
        $this->columns = $columns;

        return $this;
    }
}
