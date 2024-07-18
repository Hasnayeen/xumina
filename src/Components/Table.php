<?php

namespace Hasnayeen\Xumina\Components;

use Hasnayeen\Xumina\Components\Concerns\HasPagination;
use Hasnayeen\Xumina\Components\Table\Concerns\Searchable;
use Hasnayeen\Xumina\Components\Table\Concerns\Sortable;
use Hasnayeen\Xumina\Enums\ComponentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Table
{
    use HasPagination;
    use Searchable;
    use Sortable;

    private function __construct(
        protected string $id,
        protected string $name,
        protected ?Model $model = null,
        protected ?Builder $query = null,
        protected array $spec = [],
        protected array|Collection|null $records = null,
        protected array $columns = [],
        protected array $with = [],
    ) {
        $this->searchable = true;
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

    public function query(Builder $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function records(array|Collection $records): static
    {
        $this->records = $records;

        return $this;
    }

    public function columns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function with(array $relations): static
    {
        $this->with = $relations;

        return $this;
    }

    public function getQuery(): Builder
    {
        if ($this->query) {
            return $this->query;
        }
        $query = $this->model::query();
        $relations = collect($this->with)
            ->merge($this->inferRelations())
            ->filter()
            ->toArray();

        return $query->with($relations);
    }

    protected function inferRelations(): array
    {
        $relations = collect();
        foreach ($this->columns as $column) {
            $relation = $column->toArray()['data']['relation'];
            if (! str_contains($relation, '.')) {
                continue;
            }
            [$relation, $attribute] = explode('.', $relation);
            if ($relations->isEmpty()) {
                $relations->push($relation.':id,'.$attribute);

                continue;
            }
            $relations->transform(function ($item) use ($relation, $attribute) {
                if (Str::startsWith($item, $relation)) {
                    $item .= ','.$attribute;
                } else {
                    $relations->push($relation.':id,'.$attribute);
                }

                return $item;
            });
        }

        return $relations->toArray();
    }

    public function toArray(): array
    {
        $query = $this->getQuery();

        return [
            'id' => $this->id,
            'type' => ComponentType::Table->value,
            'data' => [
                'queryKey' => [$this->name, 'list'],
                'columns' => array_map(fn ($column) => $column->toArray(), $this->columns),
                'model' => array_reduce($this->columns, function ($carry, $item) {
                    $carry[$item->toArray()['data']['name']] = $item->toArray()['data']['type'];

                    return $carry;
                }, []),
                'pagination' => $this->records ?? match ([$this->paginated, $this->perPage]) {
                    [false, $this->perPage], [true, 'all'] => $query->paginate(1000 ?? $this->model::count()),
                    [true, $this->perPage] => $query->paginate($this->perPage),
                },
                'pageSizeOptions' => $this->pageSizeOptions,
                'globalSort' => $this->sortable,
                'globalSearch' => $this->searchable && Arr::first($this->columns, fn ($column) => $column->toArray()['data']['searchable']),
            ],
        ];
    }
}
