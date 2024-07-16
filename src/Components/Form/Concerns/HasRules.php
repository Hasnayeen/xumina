<?php

namespace Hasnayeen\Xumina\Components\Form\Concerns;

trait HasRules
{
    protected string|array $rules = [];

    public function rules(string|array $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    public function getRules(): string|array
    {
        return $this->rules;
    }
}
