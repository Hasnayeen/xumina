<?php

namespace Hasnayeen\Xumina;

use App\Http\Middleware\HandleInertiaRequests;
use Composer\InstalledVersions;
use Hasnayeen\Xumina\Commands\InstallCommand;
use Hasnayeen\Xumina\Commands\LayoutCommand;
use Hasnayeen\Xumina\Commands\PanelCommand;
use Hasnayeen\Xumina\Commands\ResourceCommand;
use Hasnayeen\Xumina\Commands\SyncCommand;
use Hasnayeen\Xumina\Commands\ThemeCommand;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class XuminaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('xumina')
            ->hasCommands([
                InstallCommand::class,
                PanelCommand::class,
                ResourceCommand::class,
                LayoutCommand::class,
                SyncCommand::class,
                ThemeCommand::class,
            ]);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();
        $this->app->singleton(Xumina::class, fn(Application $app) => new Xumina);
        $this->app->alias(Xumina::class, 'xumina');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
        $xumina = app('xumina');
        Route::middleware(['web', HandleInertiaRequests::class])
            ->group(__DIR__ . '/../routes/web.php');
        $xumina->getPanels()
            ->each(function (Panel $panel) use ($xumina) {
                if (request()->segments() && request()->segments()[0] === $panel->getPrefix()) {
                    $xumina->currentPanel($panel->getName());
                    Authenticate::redirectUsing(fn() => route('xumina.' . Str::kebab($panel->getName()) . '.auth.login'));

                    return false;
                }
                if (in_array($panel->getPrefix(), ['', '/'])) {
                    $xumina->currentPanel($panel->getName());
                    Authenticate::redirectUsing(fn() => route('xumina.' . Str::kebab($panel->getName()) . '.auth.login'));

                    return false;
                }
            });
    }

    public function packageBooted(): void
    {
        if (class_exists(AboutCommand::class) && class_exists(InstalledVersions::class)) {
            AboutCommand::add('Xumina', [
                'Version' => InstalledVersions::getPrettyVersion('hasnayeen/xumina'),
            ]);
        }
    }
}
