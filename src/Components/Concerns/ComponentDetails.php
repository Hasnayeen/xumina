<?php

namespace Hasnayeen\Xumina\Components\Concerns;

trait ComponentDetails
{
    public function getName(): string
    {
        return $this->name;
    }
}
