<?php

namespace Hasnayeen\Xumina;

use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;

abstract class Page
{
    protected static ?string $model = null;

    protected static ?string $panel = null;

    protected static ?string $resource = null;

    protected static ?string $title = null;

    public function __construct(
        protected Content $content,
        protected Layout $layout,
    ) {
        if (! Str::contains(request()->route()->getName(), 'auth')) {
            $callback = Xumina::getCurrentPanel()->getAuthorizationCallback();
            Gate::allowIf($callback ? call_user_func($callback, auth()->user()) : true);
            $this->authorize();
        }
        Inertia::share('title', static::getPageTitle());
        Xumina::getCurrentPanel()->currentPage($this);
    }

    abstract public function outline(): array;

    abstract public static function routes(): array;

    protected function authorize()
    {
        if (method_exists($this, 'authorize')) {
            Gate::allowIf($this->authorize());

            return;
        }

        if (! Gate::getPolicyFor(static::$model)) {
            return;
        }

        if (static::$model) {
            $action = request()->route()->getActionMethod();
            $model = static::$model;
            $record = request()->route()->parameter(Str::kebab($model));

            $policyMethod = $this->mapMethodToPolicy($action);

            if ($record) {
                Gate::authorize($policyMethod, $record);
            } else {
                Gate::authorize($policyMethod, $model);
            }
        }
    }

    protected function mapMethodToPolicy($method)
    {
        $map = [
            'index' => 'viewAny',
            'show' => 'view',
            'store' => 'create',
            'update' => 'update',
            'destroy' => 'delete',
        ];

        return $map[$method] ?? $method;
    }

    public static function getMiddlewares(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return '';
    }

    public static function getNavigationRoute(): string
    {
        return '';
    }

    public static function getNavigationRouteName(): string
    {
        return '';
    }

    public static function getNavigationIcon(): string
    {
        return '';
    }

    public static function isNavigationActive(): bool
    {
        return false;
    }

    public function content(): array
    {
        return $this->content->outline($this->outline());
    }

    public function layout(): array
    {
        return $this->layout->outline(Xumina::getCurrentPanel()->getLayout()->outline());
    }

    public function getModel(): ?Model
    {
        return new $this::$model ?? null;
    }

    public static function getModelName(): string
    {
        return class_basename(static::$model);
    }

    public static function getPanelName(): string
    {
        return static::$panel;
    }

    public static function getResourceName(): ?string
    {
        return static::$resource;
    }

    public static function getPageTitle(): ?string
    {
        return static::$title;
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function breadcrumb(): array
    {
        return [
            [
                'text' => $title = Xumina::getCurrentPanel()->getRootPage()::getPageTitle(),
                'url' => route('xumina.' . Str::kebab(Xumina::getCurrentPanel()->getName()) . '.' . Str::kebab($title)),
            ],
        ];
    }

    public static function getNavigationOrder(): int
    {
        return 1;
    }

    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    public static function showInNavigation(): bool
    {
        return true;
    }

    public function getPageHeaderActions(): array
    {
        return [];
    }

    public function getPageFooterActions(): array
    {
        return [];
    }

    /**
     * @return array<string,mixed>
     */
    public function data(): array
    {
        Inertia::share(Xumina::share(request()));

        $recursiveArrayIterator = function ($array) use (&$recursiveArrayIterator) {
            return array_map(function ($item) use ($recursiveArrayIterator) {
                if (is_array($item)) {
                    return $recursiveArrayIterator($item);
                }

                return $item->toArray();
            }, $array);
        };

        return [
            'layout' => $this->layout(),
            'content' => $this->content(),
            'breadcrumb' => $this->breadcrumb(),
            'navigations' => $recursiveArrayIterator(Xumina::getCurrentPanel()->getNavigations()),
        ];
    }
}
