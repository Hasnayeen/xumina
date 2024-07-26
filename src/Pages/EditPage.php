<?php

namespace Hasnayeen\Xumina\Pages;

use Hasnayeen\Xumina\Components\Concerns\HasRecord;
use Hasnayeen\Xumina\Components\Form\Concerns\HasForm;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Page;
use Illuminate\Support\Str;

class EditPage extends Page
{
    use HasForm;
    use HasRecord;

    public function outline(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [];
    }

    public function breadcrumb(): array
    {
        return [
            ...parent::breadcrumb(),
            [
                'text' => static::getResourceName(),
                'url' => $this->getResource()->getNavigationRoute(),
            ],
            [
                'text' => 'Edit',
                'url' => static::getNavigationRoute($this->getRecord()),
            ],
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Edit'.static::getModelName();
    }

    public static function getNavigationRoute(mixed $record = null): string
    {
        if ($record) {
            return route(static::getNavigationRouteName(), [
                Str::kebab(static::getModelName()) => $record,
            ]);
        }
        throw new \Exception('Record is required to generate route');
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.
            Str::kebab(Xumina::getCurrentPanel()->getName()).
            '.'.
            Str::kebab(static::getResourceName()).
            '.edit';
    }

    public static function getNavigationOrder(): int
    {
        return 0;
    }

    public static function showInNavigation(): bool
    {
        return false;
    }

    public static function isNavigationActive(): bool
    {
        return false;
    }
}
