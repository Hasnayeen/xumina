<?php

namespace Hasnayeen\Xumina\Commands\Concerns;

use Illuminate\Support\Facades\Schema;

trait CanGenerateFormFields
{
    protected function generateFormFields(string $fqcn): string
    {
        $model = new $fqcn;
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        $fields = [];

        foreach ($columns as $column) {
            $columnType = Schema::getColumnType($table, $column);

            if (in_array($column, ['id', 'created_at', 'updated_at'])) {
                continue;
            }

            $field = match ($columnType) {
                'string' => "\Hasnayeen\Xumina\Components\Form\Input::make('{$column}')",
                'text' => "\Hasnayeen\Xumina\Components\Form\Textarea::make('{$column}')",
                'integer',
                'bigint' => "\Hasnayeen\Xumina\Components\Form\Input::make('{$column}')->type('number')",
                'boolean' => "\Hasnayeen\Xumina\Components\Form\Checkbox::make('{$column}')",
                'date',
                'datetime' => "\Hasnayeen\Xumina\Components\Form\DatePicker::make('{$column}')",
                default => "\Hasnayeen\Xumina\Components\Form\Input::make('{$column}')",
            };

            $fields[] = $field;
        }

        return implode(",\n            ", $fields);
    }
}
