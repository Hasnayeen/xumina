<?php

namespace Hasnayeen\Xumina;

use Closure;
use Hasnayeen\Xumina\Components\Icon;
use Hasnayeen\Xumina\Contracts\Layout;
use Hasnayeen\Xumina\Contracts\Theme;
use Hasnayeen\Xumina\Enums\ThemesEnum;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Layouts\AuthLayout;
use Hasnayeen\Xumina\Layouts\DefaultLayout;
use Hasnayeen\Xumina\Pages\AuthPage;
use Hasnayeen\Xumina\Pages\CreatePage;
use Hasnayeen\Xumina\Pages\ListPage;
use Hasnayeen\Xumina\Themes\DefaultTheme;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\StructureDiscoverer\Discover;
use TKey;
use TValue;

class Panel
{
    public function __construct(
        protected string $name,
        protected ?string $prefix = null,
        protected ?string $path = null,
        protected ?Page $currentPage = null,
        protected ?string $rootPage = null,
        protected string $layout = DefaultLayout::class,
        protected string $authLayout = AuthLayout::class,
        protected ?string $logoPath = null,
        protected ?string $logoText = null,
        protected ?string $theme = DefaultTheme::class,
        protected array $navigations = [],
        protected ?Closure $authorizationCallback = null,
    ) {}

    public function authorize(Closure $callback): static
    {
        $this->authorizationCallback = $callback;

        return $this;
    }

    public function getAuthorizationCallback()
    {
        return $this->authorizationCallback;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMiddlewares(): array
    {
        return [];
    }

    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix ?? Str::kebab($this->getName());
    }

    public function getPath(): string
    {
        return $this->path ?? app_path('Xumina/' . Str::studly($this->getName()));
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function getResources(): Collection
    {
        return collect(
            Discover::in($this->getPath())
                ->classes()
                ->extending(Resource::class)
                ->get()
        );
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function getPages(): Collection
    {
        return collect(
            Discover::in($this->getPath())
                ->classes()
                ->extending(Page::class, AuthPage::class, CreatePage::class, ListPage::class)
                ->get()
        );
    }

    public function currentPage(Page $page): static
    {
        $this->currentPage = $page;

        return $this;
    }

    public function getCurrentPage(): Page
    {
        return $this->currentPage;
    }

    public function rootPage(string $rootPage): static
    {
        $this->rootPage = $rootPage;

        return $this;
    }

    public function getRootPage(): string
    {
        return $this->rootPage ?? $this->getPages()->filter(fn($page) => class_basename($page) === 'Dashboard')->first();
    }

    public function layout(string $layout): static
    {
        $this->layout = $layout;

        return $this;
    }

    public function getLayout(): Layout
    {
        return new $this->layout;
    }

    public function authLayout(string $layout): static
    {
        $this->authLayout = $layout;

        return $this;
    }

    public function getAuthLayout(): Layout
    {
        return new $this->authLayout;
    }

    public function logo(?string $path = null, ?string $text = null): static
    {
        $this->logoPath = $path ? (filter_var($path, FILTER_VALIDATE_URL) !== false ? $path : asset($path)) : null;
        $this->logoText = $text;

        return $this;
    }

    /**
     * @return array<string,?string>
     */
    public function getLogo(): array
    {
        return [
            'path' => $this->logoPath,
            'text' => $this->logoPath ? $this->logoText : $this->logoText ?? config('app.name'),
        ];
    }

    public function theme(string|ThemesEnum $theme): static
    {
        $this->theme = $theme instanceof ThemesEnum ? $theme->value : $theme;

        return $this;
    }

    public function getTheme(): Theme
    {
        return new $this->theme;
    }

    public function navigation(string $key, Navigation $navigation): static
    {
        $this->navigations[$key] = $navigation;

        return $this;
    }

    public function getNavigation(string $key): Navigation
    {
        return $this->navigations[$key];
    }

    public function navigations(array $navigations): static
    {
        $this->navigations = $navigations;

        return $this;
    }

    /**
     * @return array<string, Navigation>
     */
    public function getNavigations(): array
    {
        data_set(
            $this->navigations,
            'primary',
            Navigation::make()
                ->items(
                    Xumina::getCurrentPanel()
                        ->getPages()
                        ->filter(fn($page) => ! Str::contains($page, 'Auth'))
                        ->concat(Xumina::getCurrentPanel()->getResources())
                        ->map(function ($item) {
                            if ($item::showInNavigation()) {
                                $navItem = NavigationItem::make()
                                    ->label($item::getNavigationLabel())
                                    ->url($item::getNavigationRoute())
                                    ->active($item::isNavigationActive())
                                    ->order($item::getNavigationOrder())
                                    ->icon($item::getNavigationIcon() ? Icon::get($item::getNavigationIcon()) : null)
                                    ->badge($item::getNavigationBadge());

                                return $navItem;
                            }
                        })
                        ->filter()
                        ->toArray(),
                ),
            false,
        );

        return $this->navigations;
    }
}
