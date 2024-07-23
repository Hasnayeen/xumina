<?php

namespace Hasnayeen\Xumina\Components\Block;

use Hasnayeen\Xumina\Components\Concerns\HasTrigger;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Notification
{
    use HasTrigger;

    private function __construct(
        protected string $id,
    ) {}

    public static function make(): static
    {
        return new self(Str::ulid());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Notification->value,
            'data' => [
                'trigger' => $this->trigger,
                'triggerVariant' => $this->triggerVariant,
                'triggerSize' => $this->triggerSize,
            ],
        ];
    }
}
