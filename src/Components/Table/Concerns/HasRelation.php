<?php

namespace Hasnayeen\Xumina\Components\Table\Concerns;

trait HasRelation
{
    protected ?string $relation = null;

    public function relation(?string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }
}
