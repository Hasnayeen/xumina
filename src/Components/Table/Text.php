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
    ) {}

    public static function make(?string $name = null): static
    {
        return new self(Str::ulid(), $name);
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => 'Text',
            'data' => [
                'name' => $this->name,
                'type' => 'string',
                'header' => Str::headline($this->header ?? $this->name),
                'limit' => $this->limit,
                'sortable' => $this->sortable,
                'searchable' => $this->searchable,
                'individuallySearchable' => $this->individuallySearchable,
                'globallySearchable' => $this->globallySearchable,
            ],
        ];
    }
}
