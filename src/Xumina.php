<?php

namespace Hasnayeen\Xumina;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use TKey;
use TValue;

class Xumina
{
    protected array $panels = [];

    protected ?string $currentPanel = null;

    public function registerPanel($name): Panel
    {
        $this->panels[$name] = resolve(Panel::class, ['name' => $name]);

        return $this->panels[$name];
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function getPanels(): Collection
    {
        return collect($this->panels);
    }

    public function getPanel(string $name): Panel
    {
        if (array_key_exists($name, $this->panels)) {
            return $this->panels[$name];
        }
        throw new Exception("Unknown panel named '{$name}'");
    }

    public function currentPanel(string $panel): static
    {
        $this->currentPanel = $panel;

        return $this;
    }

    public function getCurrentPanel(): ?Panel
    {
        return $this->currentPanel ? $this->getPanel($this->currentPanel) : null;
    }

    public static function getInertiaPath(string $path): string
    {
        return collect(explode('.', $path))
            ->filter(fn ($item) => $item !== 'xumina')
            ->pipe(
                fn ($collection) => $collection
                    ->join('/')
            );
    }

    public function share(Request $request): array
    {
        $panel = $this->getCurrentPanel()->getName();

        return [
            'panel' => $panel,
            'routePrefix' => 'xumina.'.Str::kebab($panel),
            'flash' => [
                'message' => session('message'),
                'type' => session('type'),
                'oldInput' => session('_old_input'),
            ],
        ];
    }
}
