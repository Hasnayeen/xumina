<?php

namespace Hasnayeen\Xumina\Commands;

use Hasnayeen\Xumina\Commands\Concerns\InteractWithFileSystem;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

#[AsCommand(name: 'xumina:panel')]
class PanelCommand extends Command implements PromptsForMissingInput
{
    use InteractWithFileSystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xumina:panel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and scaffold a panel';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $name = text(
            label: 'Name of the panel?',
            placeholder: 'Admin',
            default: 'Admin',
            required: true,
        );
        if ($this->checkPanelExistence($name)) {
            $overwrite = confirm(
                label: "A panel named {$name} already exists, overwrite?",
                default: false,
            );
            if (! $overwrite) {
                $this->components->error('Panel already exists. Aborting!');

                return 1;
            }
        }

        $this->createPanelDirectories($name);
        $this->copyAuthFiles($name);
        $this->createDashboardPage($name);
        $this->createReactPage($name);
    }

    protected function createPanelDirectories(string $name): void
    {
        if (! File::exists(app_path('Providers/Xumina'))) {
            File::makeDirectory(app_path('Providers/Xumina'));
        }
        $this->call('make:provider', ['name' => 'Xumina/' . Str::studly($name) . 'ServiceProvider', '--force' => true]);
        $content = File::get(__DIR__ . '/../../stubs/app/Providers/Xumina/PanelServiceProvider.php');
        File::put(app_path('Providers/Xumina/' . Str::studly($name) . 'ServiceProvider.php'), $content);
        $this->replaceInFile('{{ $class }}', Str::studly($name) . 'ServiceProvider', app_path('Providers/Xumina/' . Str::studly($name) . 'ServiceProvider.php'));
        $this->replaceInFile('{{ $name }}', $name, app_path('Providers/Xumina/' . Str::studly($name) . 'ServiceProvider.php'));
        File::makeDirectory(app_path('Xumina/'), force: true);
        File::makeDirectory(app_path('Xumina/' . Str::studly($name)), force: true);
        File::makeDirectory(app_path('Xumina/' . Str::studly($name) . '/Pages'), force: true);
        File::makeDirectory(app_path('Xumina/' . Str::studly($name) . '/Controllers'), force: true);
        File::makeDirectory(app_path('Xumina/' . Str::studly($name) . '/Resources'), force: true);

        if (! File::exists(resource_path('js/pages/' . Str::kebab($name)))) {
            File::makeDirectory(resource_path('js/pages/' . Str::kebab($name)));
        }
    }

    protected function copyAuthFiles(string $name): void
    {
        // $auth = confirm(
        //     label: 'Do you want auth?',
        //     default: false,
        //     hint: 'Generate auth scaffolding(routes, controllers, views etc) for the panel.'
        // );
        $auth = true;
        if ($auth) {
            File::copyDirectory(
                __DIR__ . '/../../stubs/app/Xumina/Controllers/Auth',
                app_path('Xumina/' . Str::studly($name) . '/Controllers/Auth')
            );
            File::copyDirectory(
                __DIR__ . '/../../stubs/app/Xumina/Requests/Auth',
                app_path('Xumina/' . Str::studly($name) . '/Requests/Auth')
            );
            $this->replaceInFile('{{ $panel }}', Str::studly($name), app_path('Xumina/' . Str::studly($name) . '/Requests/Auth/LoginRequest.php'));

            foreach (File::files(app_path('Xumina/' . Str::studly($name) . '/Controllers/Auth')) as $file) {
                $this->replaceInFile('{{ $panel }}', Str::studly($name), $file->getPathname());
                $this->replaceInFile('{{ $inertia }}', Str::kebab($name) . '/', $file->getPathname());
                $this->replaceInFile('{{ $route }}', 'xumina.' . Str::kebab($name) . '.', $file->getPathname());
            }
            File::copyDirectory(
                __DIR__ . '/../../stubs/app/Xumina/Pages/Auth',
                app_path('Xumina/' . Str::studly($name) . '/Pages/Auth'),
            );
            foreach (File::files(app_path('Xumina/' . Str::studly($name) . '/Pages/Auth')) as $file) {
                $this->replaceInFile('{{ $panel }}', Str::studly($name), $file->getPathname());
            }
            if (! File::exists(resource_path('js/pages/' . Str::kebab($name) . '/auth'))) {
                File::makeDirectory(resource_path('js/pages/' . Str::kebab($name) . '/auth'));
            }
            File::copy(__DIR__ . '/../../stubs/ts/resources/js/pages/auth/login.tsx', resource_path('js/pages/' . Str::kebab($name) . '/auth/login.tsx'));
            File::copy(__DIR__ . '/../../stubs/ts/resources/js/pages/auth/register.tsx', resource_path('js/pages/' . Str::kebab($name) . '/auth/register.tsx'));
            $this->components->info('Auth scafollded successfully.');
        }
    }

    protected function createDashboardPage(string $name): void
    {
        File::copy(__DIR__ . '/../../stubs/app/Xumina/Pages/Dashboard.php', app_path('Xumina/' . Str::studly($name) . '/Pages/Dashboard.php'));
        $this->replaceInFile('{{ $panel }}', Str::studly($name), $filePath = app_path('Xumina/' . Str::studly($name) . '/Pages/Dashboard.php'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'Page', $filePath));

        File::copy(__DIR__ . '/../../stubs/app/Xumina/Controllers/DashboardController.php', app_path('Xumina/' . Str::studly($name) . '/Controllers/DashboardController.php'));
        $this->replaceInFile('{{ $panel }}', Str::studly($name), $filePath = app_path('Xumina/' . Str::studly($name) . '/Controllers/DashboardController.php'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'Controller', $filePath));
    }

    protected function createReactPage(string $name): void
    {
        if (! File::exists(resource_path('js/pages/' . Str::kebab($name)))) {
            File::makeDirectory(resource_path('js/pages/' . Str::kebab($name)), force: true);
        }
        File::copy(__DIR__ . '/../../stubs/ts/resources/js/pages/dashboard.tsx', $filePath = resource_path('js/pages/' . Str::kebab($name) . '/dashboard.tsx'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'React component', $filePath));
    }
}
