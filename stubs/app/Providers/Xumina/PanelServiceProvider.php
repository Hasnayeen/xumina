<?php

namespace App\Providers\Xumina;

use Hasnayeen\Xumina\Layouts\DefaultLayout;
use Hasnayeen\Xumina\Xumina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class {{ $class }} extends ServiceProvider
{
    protected Panel $panel;

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->panel = app('xumina')->registerPanel('{{ $name }}');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Model::unguard();
        $this->panel
            ->layout(DefaultLayout::class);
    }
}
