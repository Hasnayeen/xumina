<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Action
{
    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $label = null,
        protected ?string $icon = null,
        protected bool $asButton = true,
        protected ?string $url = null,
        protected ?string $action = null,
        protected ?string $actionType = null,
        protected ?array $confirmationDialog = null,
        protected ?array $dialog = null,
    ) {}

    public static function make(?string $name = null): static
    {
        return new self(Str::ulid(), $name);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function asButton(bool $condition = true): static
    {
        $this->asButton = $condition;

        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;
        $this->actionType = 'url';

        return $this;
    }

    public function confirmationDialog(string $title, string $description, string $confirmLabel = 'Confirm', string $cancelLabel = 'Cancel'): static
    {
        $this->confirmationDialog = [
            'title' => $title,
            'description' => $description,
            'confirmLabel' => $confirmLabel,
            'cancelLabel' => $cancelLabel,
        ];
        $this->actionType = 'confirmationDialog';

        return $this;
    }

    public function dialog(string $title, ?string $description = null, array $content = [], array $footer = []): static
    {
        $this->dialog = [
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'footer' => $footer,
        ];
        $this->actionType = 'dialog';

        return $this;
    }

    public function dialogTitle(string $title): static
    {
        if ($this->dialog) {
            $this->dialog['title'] = $title;
        }

        return $this;
    }

    public function dialogDescription(string $description): static
    {
        if ($this->dialog) {
            $this->dialog['description'] = $description;
        }

        return $this;
    }

    public function dialogContent(array $content): static
    {
        if ($this->dialog) {
            $this->dialog['content'] = $content;
        }

        return $this;
    }

    public function dialogFooter(array $footer): static
    {
        if ($this->dialog) {
            $this->dialog['footer'] = $footer;
        }

        return $this;
    }

    public function submitButton(string $label = 'Submit', ?string $action = null): static
    {
        if ($this->dialog) {
            $this->dialog['footer'][] = [
                'type' => 'Button',
                'data' => [
                    'label' => $label,
                    'variant' => 'primary',
                    'action' => $action,
                ],
            ];
        }

        return $this;
    }

    public function cancelButton(string $label = 'Cancel', ?string $action = null): static
    {
        if ($this->dialog) {
            $this->dialog['footer'][] = [
                'type' => 'Button',
                'data' => [
                    'label' => $label,
                    'variant' => 'secondary',
                    'action' => $action,
                ],
            ];
        }

        return $this;
    }

    public function emitEvent(string $eventName): static
    {
        $this->action = $eventName;
        $this->actionType = 'emitEvent';

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Action->value,
            'data' => [
                'label' => $this->label ?? Str::headline($this->name) ?? null,
                'icon' => $this->icon ? Icon::get($this->icon) : null,
                'url' => $this->url,
                'asButton' => $this->asButton ?? (bool) $this->url,
                'actionType' => $this->actionType,
                'confirmationDialog' => $this->confirmationDialog,
                'dialog' => $this->dialog,
                'action' => $this->action,
            ],
        ];
    }
}
