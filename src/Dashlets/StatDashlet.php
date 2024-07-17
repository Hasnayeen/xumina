<?php

namespace Hasnayeen\Xumina\Dashlets;

use Hasnayeen\Xumina\Components\Label;
use Hasnayeen\Xumina\Components\Section;
use Hasnayeen\Xumina\Dashlet;
use Illuminate\Support\Str;

class StatDashlet extends Dashlet
{
    protected mixed $value;

    public function outline(): array
    {
        return [
            Section::make(Str::headline($this->name))
                ->items([
                    Label::make()
                        ->body($this->value)
                ])
        ];
    }

    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }
}
