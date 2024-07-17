<?php

namespace Hasnayeen\Xumina\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\select;

#[AsCommand(name: 'xumina:install')]
class InstallCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xumina:install
                            {--pest : Indicate that Pest should be installed} 
                            {--typescript : Indicates if TypeScript is preferred}
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and scaffold Xumina panel builder';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        return $this->installInertiaReactStack();
    }

    protected function installInertiaReactStack()
    {
        // Install Inertia...
        if (! $this->requireComposerPackages(['inertiajs/inertia-laravel:^1.0', 'laravel/sanctum:^4.0', 'tightenco/ziggy:^2.0'])) {
            return 1;
        }

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/react' => '^1.0.0',
                '@radix-ui/react-accordion' => '^1.2.0',
                '@radix-ui/react-alert-dialog' => '^1.1.1',
                '@radix-ui/react-aspect-ratio' => '^1.1.0',
                '@radix-ui/react-avatar' => '^1.1.0',
                '@radix-ui/react-checkbox' => '^1.1.1',
                '@radix-ui/react-collapsible' => '^1.1.0',
                '@radix-ui/react-context-menu' => '^2.2.1',
                '@radix-ui/react-dialog' => '^1.1.1',
                '@radix-ui/react-dropdown-menu' => '^2.1.1',
                '@radix-ui/react-hover-card' => '^1.1.1',
                '@radix-ui/react-label' => '^2.1.0',
                '@radix-ui/react-menubar' => '^1.1.1',
                '@radix-ui/react-navigation-menu' => '^1.2.0',
                '@radix-ui/react-popover' => '^1.1.1',
                '@radix-ui/react-progress' => '^1.1.0',
                '@radix-ui/react-radio-group' => '^1.2.0',
                '@radix-ui/react-scroll-area' => '^1.1.0',
                '@radix-ui/react-select' => '^2.1.1',
                '@radix-ui/react-separator' => '^1.1.0',
                '@radix-ui/react-slider' => '^1.2.0',
                '@radix-ui/react-slot' => '^1.1.0',
                '@radix-ui/react-switch' => '^1.1.0',
                '@radix-ui/react-tabs' => '^1.1.0',
                '@radix-ui/react-toast' => '^1.2.1',
                '@radix-ui/react-toggle' => '^1.1.0',
                '@radix-ui/react-toggle-group' => '^1.1.0',
                '@radix-ui/react-tooltip' => '^1.1.2',
                '@tailwindcss/forms' => '^0.5.3',
                '@tanstack/react-form' => '^0.21.0',
                '@tanstack/react-query' => '^5.45.1',
                '@tanstack/react-table' => '^8.17.3',
                '@vitejs/plugin-react' => '^4.2.0',
                'autoprefixer' => '^10.4.12',
                'class-variance-authority' => '^0.7.0',
                'clsx' => '^2.1.1',
                'cmdk' => '^1.0.0',
                'embla-carousel-react' => '^8.1.6',
                'input-otp' => '^1.2.4',
                'lucide-react' => '^0.379.0',
                'next-themes' => '^0.3.0',
                'postcss' => '^8.4.31',
                'recharts' => '^2.12.7',
                'react' => '^18.2.0',
                'react-day-picker' => '^8.10.1',
                'react-dom' => '^18.2.0',
                'sonner' => '^1.5.0',
                'tailwindcss' => '^3.4.1',
                'tailwind-merge' => '^2.3.0',
                'tailwindcss-animate' => '^1.0.7',
                'vaul' => '^0.9.1',
            ] + $packages;
        });

        if (true || $this->option('typescript')) {
            $this->updateNodePackages(function ($packages) {
                return [
                    '@types/lodash' => '^4.17.6',
                    '@types/node' => '^18.13.0',
                    '@types/react' => '^18.0.28',
                    '@types/react-dom' => '^18.0.10',
                    'typescript' => '^5.0.2',
                ] + $packages;
            });
        }

        // Middleware...
        $this->installMiddleware([
            '\App\Http\Middleware\HandleInertiaRequests::class',
            '\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class',
        ]);

        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        copy(__DIR__.'/../../stubs/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // Views...
        copy(__DIR__.'/../../stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        @unlink(resource_path('views/welcome.blade.php'));

        // Components + Pages...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/pages'));

        if (true || $this->option('typescript')) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/components', resource_path('js/components'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/layouts', resource_path('js/layouts'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/pages', resource_path('js/pages'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/lib', resource_path('js/lib'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/types', resource_path('js/types'));
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/js/resources/js/Components', resource_path('js/Components'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/js/resources/js/Layouts', resource_path('js/Layouts'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/js/resources/js/Pages', resource_path('js/Pages'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/ts/resources/js/lib', resource_path('js/lib'));
        }

        // Tests...
        if (! $this->installTests()) {
            return 1;
        }

        if ($this->option('pest')) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/pest-tests/Feature', base_path('tests/Feature'));
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));
        }

        // Routes...
        copy(__DIR__.'/../../stubs/routes/web.php', base_path('routes/web.php'));

        // Tailwind / Vite...
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));

        if (true || $this->option('typescript')) {
            copy(__DIR__.'/../../stubs/ts/tsconfig.json', base_path('tsconfig.json'));
            copy(__DIR__.'/../../stubs/ts/resources/js/app.tsx', resource_path('js/app.tsx'));

            if (file_exists(resource_path('js/bootstrap.js'))) {
                rename(resource_path('js/bootstrap.js'), resource_path('js/bootstrap.ts'));
            }

            $this->replaceInFile('"vite build', '"tsc && vite build', base_path('package.json'));
            $this->replaceInFile('.jsx', '.tsx', base_path('vite.config.js'));
            $this->replaceInFile('.jsx', '.tsx', resource_path('views/app.blade.php'));
            $this->replaceInFile('.jsx', '.tsx', base_path('tailwind.config.js'));
            $this->replaceInFile('.js', '.ts', base_path('tailwind.config.js'));
        } else {
            copy(__DIR__.'/../../stubs/js/jsconfig.json', base_path('jsconfig.json'));
            copy(__DIR__.'/../../stubs/js/resources/js/app.jsx', resource_path('js/app.jsx'));
        }

        if (file_exists(resource_path('js/app.js'))) {
            unlink(resource_path('js/app.js'));
        }

        $this->call('xumina:sync');

        $this->components->info('Installing and building Node dependencies.');

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } elseif (file_exists(base_path('bun.lockb'))) {
            $this->runCommands(['bun install', 'bun run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Xumina scaffolding installed successfully. Let\'s Go 🚀');
    }

    /**
     * Install Breeze's tests.
     *
     * @return bool
     */
    protected function installTests()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));

        $stubStack = 'default';

        if ($this->option('pest') || $this->isUsingPest()) {
            if ($this->hasComposerPackage('phpunit/phpunit')) {
                $this->removeComposerPackages(['phpunit/phpunit'], true);
            }

            if (! $this->requireComposerPackages(['pestphp/pest:^2.0', 'pestphp/pest-plugin-laravel:^2.0'], true)) {
                return false;
            }

            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/pest-tests/Feature', base_path('tests/Feature'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/pest-tests/Unit', base_path('tests/Unit'));
            (new Filesystem)->copy(__DIR__.'/../../stubs/pest-tests/Pest.php', base_path('tests/Pest.php'));
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));
        }

        return true;
    }

    /**
     * Install the given middleware names into the application.
     *
     * @param  array|string  $names
     * @param  string  $group
     * @param  string  $modifier
     * @return void
     */
    protected function installMiddleware($names, $group = 'web', $modifier = 'append')
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $names = collect(Arr::wrap($names))
            ->filter(fn ($name) => ! Str::contains($bootstrapApp, $name))
            ->whenNotEmpty(function ($names) use ($bootstrapApp, $group, $modifier) {
                $names = $names->map(fn ($name) => "$name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware) {',
                    '->withMiddleware(function (Middleware $middleware) {'
                        .PHP_EOL."        \$middleware->$group($modifier: ["
                        .PHP_EOL."            $names,"
                        .PHP_EOL.'        ]);'
                        .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }

    /**
     * Install the given middleware aliases into the application.
     *
     * @param  array  $aliases
     * @return void
     */
    protected function installMiddlewareAliases($aliases)
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $aliases = collect($aliases)
            ->filter(fn ($alias) => ! Str::contains($bootstrapApp, $alias))
            ->whenNotEmpty(function ($aliases) use ($bootstrapApp) {
                $aliases = $aliases->map(fn ($name, $alias) => "'$alias' => $name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware) {',
                    '->withMiddleware(function (Middleware $middleware) {'
                        .PHP_EOL.'        $middleware->alias(['
                        .PHP_EOL."            $aliases,"
                        .PHP_EOL.'        ]);'
                        .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }

    /**
     * Determine if the given Composer package is installed.
     *
     * @param  string  $package
     * @return bool
     */
    protected function hasComposerPackage($package)
    {
        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        return array_key_exists($package, $packages['require'] ?? [])
            || array_key_exists($package, $packages['require-dev'] ?? []);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  bool  $asDev
     * @return bool
     */
    protected function requireComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Removes the given Composer Packages from the application.
     *
     * @param  bool  $asDev
     * @return bool
     */
    protected function removeComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

    /**
     * Remove Tailwind dark classes from the given files.
     *
     * @return void
     */
    protected function removeDarkClasses(Finder $finder)
    {
        foreach ($finder as $file) {
            file_put_contents($file->getPathname(), preg_replace('/\sdark:[^\s"\']+/', '', $file->getContents()));
        }
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'stack' => fn () => select(
                label: 'Which Breeze stack would you like to install?',
                options: [
                    'react' => 'React with Inertia',
                ],
            ),
        ];
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        $input->setOption('pest', select(
            label: 'Which testing framework do you prefer?',
            options: ['Pest', 'PHPUnit'],
            default: $this->isUsingPest() ? 'Pest' : 'PHPUnit',
        ) === 'Pest');
    }

    /**
     * Determine whether the project is already using Pest.
     *
     * @return bool
     */
    protected function isUsingPest()
    {
        return class_exists(\Pest\TestSuite::class);
    }
}
