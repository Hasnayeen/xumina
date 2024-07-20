<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Components\Concerns\ComponentDetails;
use Hasnayeen\Xumina\Components\Form\Concerns\HasColumnSpan;
use Hasnayeen\Xumina\Components\Form\Concerns\HasGridColumns;
use Hasnayeen\Xumina\Contracts\Component;
use Hasnayeen\Xumina\Enums\ComponentType;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Pages\AuthPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Form implements Component
{
    use ComponentDetails;
    use HasColumnSpan;
    use HasGridColumns;

    private function __construct(
        protected string $id,
        protected string $name,
        protected ?Model $model = null,
        protected array $fields = [],
        protected array $rules = [],
        protected ?string $submitTo = null,
        protected ?string $submitButtonLabel = null,
        protected bool $cancelButton = true,
        protected ?string $cancelButtonLabel = null,
        protected ?string $redirectTo = null,
    ) {
        $this->columns = 3;
    }

    public static function make(string $name): static
    {
        return new self(Str::ulid(), $name);
    }

    public function model(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function fields(array $fields): static
    {
        $this->fields = $fields;
        $this->extractRules($fields);

        return $this;
    }

    public function getFillableData(array $data): array
    {
        $fieldNames = $this->getFieldNames($this->fields);

        return array_intersect_key($data, array_flip($fieldNames));
    }

    public function submitTo(string $route): static
    {
        $this->submitTo = $route;

        return $this;
    }

    public function getSubmitTo(): string
    {
        return $this->submitTo ?? 'xumina.' . Str::kebab(Xumina::getCurrentPanel()->getName()) . (Xumina::getCurrentPanel()->getCurrentPage() instanceof AuthPage ? '.auth.' : '.') . Str::kebab(Xumina::getCurrentPanel()->getCurrentPage()::getResourceName()) . '.store';
    }

    public function redirectTo(string $route): static
    {
        $this->redirectTo = $route;

        return $this;
    }

    public function getRedirectTo(): string
    {
        return $this->redirectTo ?? 'xumina.' . Str::kebab(Xumina::getCurrentPanel()->getName()) . '.' . Str::kebab(Xumina::getCurrentPanel()->getCurrentPage()::getResourceName()) . '.index';
    }

    public function submitButtonLabel(string $route): static
    {
        $this->submitButtonLabel = $route;

        return $this;
    }

    public function cancelButton(bool $condition): static
    {
        $this->cancelButton = $condition;

        return $this;
    }

    public function cancelButtonLabel(string $route): static
    {
        $this->cancelButtonLabel = $route;

        return $this;
    }

    protected function extractRules($fields)
    {
        foreach ($fields as $field) {
            if (method_exists($field, 'getRules')) {
                $this->rules[$field->getName()] = $field->getRules();
            }
            if (method_exists($field, 'getItems')) {
                $this->extractRules($field->getItems());
            }
        }
    }

    protected function getFieldNames($fields): array
    {
        $fieldsName = [];
        foreach ($fields as $field) {
            if (method_exists($field, 'getItems')) {
                $fieldsName = $this->getFieldNames($field->getItems());
            }

            $fieldsName[] = $field->getName();
        }

        return $fieldsName;
    }

    public function validate(array $data): array
    {
        return Validator::make($data, $this->rules)
            ->validate();
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ComponentType::Form->value,
            'data' => [
                'model' => $this->model ? get_class($this->model) : Xumina::getCurrentPanel()->getCurrentPage()->getModelName(),
                'fields' => array_map(fn($field) => $field->toArray(), $this->fields),
                'rules' => $this->rules,
                'submitTo' => route($this->getSubmitTo()),
                'submitButtonLabel' => $this->submitButtonLabel ?? 'Create',
                'cancelButtton' => $this->cancelButton,
                'cancelButtonLabel' => $this->cancelButtonLabel ?? 'Cancel',
                'columns' => $this->columns,
            ],
        ];
    }
}
