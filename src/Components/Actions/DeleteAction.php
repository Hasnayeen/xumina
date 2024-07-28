<?php

namespace Hasnayeen\Xumina\Components\Actions;

use Hasnayeen\Xumina\Components\Action;

class DeleteAction extends Action
{
    public static function make(?string $name = null): static
    {
        $instance = new self($name ?? 'delete');
        $instance
            ->label('Delete')
            ->icon('trash-2')
            ->variant('destructive')
            ->requireConfirmation();

        return $instance;
    }

    public function url(string $url): static
    {
        $this->action('deleteResource', ['url' => $url]);

        return $this;
    }
}
