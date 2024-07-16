<?php

namespace Hasnayeen\Xumina\Components\Table\Concerns;

trait Searchable
{
    protected bool $searchable = false;

    protected bool $individuallySearchable = false;

    protected bool $globallySearchable = true;

    public function searchable(bool $condition = true, bool $individual = false, bool $global = true): static
    {
        $this->searchable = $condition;
        $this->individuallySearchable = $individual;
        $this->globallySearchable = $global;

        return $this;
    }
}
