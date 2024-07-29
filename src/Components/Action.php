<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Support\Str;

class Action
{
    protected function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $label = null,
        protected ?string $icon = null,
        protected string $iconPosition = 'left',
        protected bool $asButton = false,
        protected ?string $variant = null,
        protected ?string $size = null,
        protected ?string $url = null,
        protected ?string $routeName = null,
        protected ?array $routeParams = null,
        protected ?string $action = null,
        protected ?array $actionData = null,
        protected ?string $actionType = null,
        protected bool $customAction = false,
        protected ?array $confirmationDialog = null,
        protected ?array $dialog = null
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

    public function iconPosition(string $position = 'left'): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function asButton(bool $condition = true): static
    {
        $this->asButton = $condition;

        return $this;
    }

    public function variant(string $variant): static
    {
        $this->variant = match ($variant) {
            'default',
            'destructive',
            'outline',
            'secondary',
            'ghost',
            'link' => $variant,
            default => throw new \Exception(
                "Unknown variant named {$variant}"
            ),
        };

        return $this;
    }

    public function size(string $size): static
    {
        $this->size = match ($size) {
            'default', 'sm', 'lg', 'icon' => $size,
            default => throw new \Exception("Unknown size named {$size}"),
        };

        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;
        $this->actionType = 'url';

        return $this;
    }

    public function route(string $name, array $params = []): static
    {
        $this->routeName = $name;
        $this->routeParams = $params;
        $this->actionType = 'url';

        return $this;
    }

    public function requireConfirmation(
        string $title = 'Delete Record',
        string $description = 'Are you sure you want to delete this resource? This action cannot be undone.'
    ): static {
        $this->confirmationDialog($title, $description);

        return $this;
    }

    public function confirmationDialog(
        string $title,
        string $description,
        string $confirmLabel = 'Confirm',
        string $cancelLabel = 'Cancel'
    ): static {
        $this->confirmationDialog = [
            'title' => $title,
            'description' => $description,
            'confirmLabel' => $confirmLabel,
            'cancelLabel' => $cancelLabel,
        ];
        $this->actionType = 'confirmationDialog';

        return $this;
    }

    public function dialog(
        string $title,
        ?string $description = null,
        array $content = [],
        array $footer = []
    ): static {
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

    public function submitButton(
        string $label = 'Submit',
        ?string $action = null
    ): static {
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

    public function cancelButton(
        string $label = 'Cancel',
        ?string $action = null
    ): static {
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

    public function action(string $action, ?array $data = null): static
    {
        $this->action = $action;
        $this->actionData = $data;
        $this->customAction = true;

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
                'label' => $this->label ?? (Str::headline($this->name) ?? null),
                'icon' => $this->icon ? Icon::get($this->icon) : null,
                'iconPosition' => $this->iconPosition,
                'url' => $this->url,
                'routeName' => $this->routeName,
                'routeParams' => $this->routeParams,
                'asButton' => $this->asButton ?? (bool) $this->url,
                'variant' => $this->variant,
                'size' => $this->size,
                'actionType' => $this->actionType,
                'confirmationDialog' => $this->confirmationDialog,
                'dialog' => $this->dialog,
                'action' => $this->action,
                'actionData' => $this->actionData,
                'customAction' => $this->customAction,
            ],
        ];
    }
}
