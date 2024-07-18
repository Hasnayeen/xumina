<?php

namespace Hasnayeen\Xumina\Components\Table;

use Hasnayeen\Xumina\Components\Table\Concerns\Searchable;
use Hasnayeen\Xumina\Components\Table\Concerns\Sortable;
use Illuminate\Support\Str;

class Text
{
    use Searchable;
    use Sortable;

    private function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?string $description = null,
        protected ?string $header = null,
        protected ?int $limit = null,
        protected ?string $relation = null,
    ) {}

    public static function make(?string $name = null): static
    {
        $instance = new self(Str::ulid());
        $instance->parseName($name);

        return $instance;
    }

    public function header(string $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function relation(?string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    protected function parseName(string $name): void
    {
        if (str_contains($name, '.')) {
            $this->relation = $this->name = $name;
        } else {
            $this->name = $name;
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => 'Text',
            'data' => [
                'name' => $this->name,
                'type' => 'string',
                'relation' => $this->relation,
                'header' => Str::headline($this->header ?? $this->relation ? explode('.', $this->name)[0] : $this->name),
                'limit' => $this->limit,
                'sortable' => $this->sortable,
                'searchable' => $this->searchable,
                'individuallySearchable' => $this->individuallySearchable,
                'globallySearchable' => $this->globallySearchable,
            ],
        ];
    }
}
