<?php

namespace Hasnayeen\Xumina;

class Content
{
    /**
     * @param  array<string,mixed>  $outline
     */
    public function __construct(protected array $outline = []) {}

    /**
     * @param  array<int,mixed>  $outline
     */
    public function outline(array $outline): array
    {
        foreach ($outline as $element) {
            $this->outline[] = $element->toArray();
        }

        return $this->outline;
    }
}
