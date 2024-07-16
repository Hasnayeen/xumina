<?php

namespace Hasnayeen\Xumina\Exceptions;

use Exception;
use Hasnayeen\Xumina\Enums\ComponentType;

class ComponentNotFound extends Exception
{
    public function __construct(ComponentType $componentType, string $name)
    {
        parent::__construct("{$componentType->value} named {$name} not found.");
    }
}
