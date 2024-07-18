<?php

namespace Hasnayeen\Xumina\Commands;

use Hasnayeen\Xumina\Commands\Concerns\InteractWithFileSystem;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Panel;
use Illuminate\Console\Command;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\ModelInfo\ModelFinder;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

#[AsCommand(name: 'xumina:resource')]
class ResourceCommand extends Command implements PromptsForMissingInput
{
    use InteractsWithIO;
    use InteractWithFileSystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xumina:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new resource';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $panel = select(
            'Which panel you want to create the resource?',
            Xumina::getPanels()->transform(fn (Panel $panel) => Str::studly($panel->getName())),
        );

        $fqcn = select(
            label: 'Resource model?',
            options: ModelFinder::all(),
            required: true,
        );
        $model = class_basename($fqcn);
        $name = Str::plural($model);
        if (File::exists(app_path('Xumina/'.$panel.'/Pages/'.$name))) {
            $overwrite = confirm(
                label: "A resource named {$name} already exists, overwrite?",
                default: false,
            );
            if (! $overwrite) {
                $this->components->error(sprintf('Resource [%s] already exists. Aborting!', $name));

                return 1;
            }
        }
        $this->createResource($panel, $model, $name);
        $this->createResourcePages($panel, $fqcn, $model, $name);
        $this->createControllers($panel, $fqcn, $model, $name);
        $this->createReactPages($panel, $name);
    }

    protected function createResource(string $panel, string $model, string $name): void
    {
        $this->ensureDirectoryExists(app_path('Xumina/'.Str::studly($panel).'/Resources'));
        File::copy(__DIR__.'/../../stubs/app/Xumina/Resources/Resource.php', $filePath = app_path('Xumina/'.$panel.'/Resources/'.$model.'.php'));
        $this->replaceInFile('{{ $panel }}', $panel, $filePath);
        $this->replaceInFile('{{ $name }}', $name, $filePath);
        $this->replaceInFile('{{ $model }}', $model, $filePath);
        $this->replaceInFile('{{ $modelHeadline }}', Str::headline($model), $filePath);
        $this->components->info(sprintf('%s [%s] created successfully.', 'Resource', $filePath));
    }

    protected function createResourcePages(string $panel, string $fqcn, string $model, string $name): void
    {
        $this->ensureDirectoryExists(app_path('Xumina/'.Str::studly($panel).'/Pages/'.$name));
        $createPageCallback = function ($template) use ($panel, $name, $model, $fqcn) {
            File::copy(
                __DIR__.'/../../stubs/app/Xumina/Pages/'.$template.'Page.php',
                $filePath = app_path('Xumina/'.$panel.'/Pages/'.$name.'/'.$template.$model.'.php')
            );
            $this->replaceInFile('{{ $panel }}', $panel, $filePath);
            $this->replaceInFile('{{ $resource }}', $name, $filePath);
            $this->replaceInFile('{{ $modelFqcn }}', $fqcn, $filePath);
            $this->replaceInFile('{{ $model }}', $model, $filePath);
            $this->replaceInFile('{{ $resourceKebab }}', Str::kebab($name), $filePath);
            $this->replaceInFile('{{ $modelKebab }}', Str::kebab($model), $filePath);
            $this->components->info(sprintf('%s [%s] created successfully.', 'Page', $filePath));
        };
        $createPageCallback('Create');
        $createPageCallback('List');
        $createPageCallback('Edit');
        $createPageCallback('View');
    }

    protected function createControllers(string $panel, string $fqcn, string $model, string $name): void
    {
        $this->ensureDirectoryExists(app_path('Xumina/'.Str::studly($panel).'/Controllers'));
        File::copy(__DIR__.'/../../stubs/app/Xumina/Controllers/Controller.php', $filePath = app_path('Xumina/'.$panel.'/Controllers/'.$model.'Controller.php'));
        $this->replaceInFile('{{ $panel }}', $panel, $filePath);
        $this->replaceInFile('{{ $resource }}', $name, $filePath);
        $this->replaceInFile('{{ $model }}', $model, $filePath);
        $this->replaceInFile('{{ $modelFqcn }}', $fqcn, $filePath);
        $this->replaceInFile('{{ $panelKebab }}', Str::kebab($panel), $filePath);
        $this->replaceInFile('{{ $modelKebab }}', Str::kebab($model), $filePath);
        $this->components->info(sprintf('%s [%s] created successfully.', 'Controller', $filePath));
    }

    protected function createReactPages(string $panel, string $name): void
    {
        $this->ensureDirectoryExists(resource_path('js/pages/'.Str::kebab($panel).'/'.Str::kebab($name)));
        File::copy(__DIR__.'/../../stubs/ts/resources/js/pages/index.tsx', $filePath = resource_path('js/pages/'.Str::kebab($panel).'/'.Str::kebab($name).'/index.tsx'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'React component', $filePath));
        File::copy(__DIR__.'/../../stubs/ts/resources/js/pages/create.tsx', $filePath = resource_path('js/pages/'.Str::kebab($panel).'/'.Str::kebab($name).'/create.tsx'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'React component', $filePath));
        File::copy(__DIR__.'/../../stubs/ts/resources/js/pages/edit.tsx', $filePath = resource_path('js/pages/'.Str::kebab($panel).'/'.Str::kebab($name).'/edit.tsx'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'React component', $filePath));
        File::copy(__DIR__.'/../../stubs/ts/resources/js/pages/view.tsx', $filePath = resource_path('js/pages/'.Str::kebab($panel).'/'.Str::kebab($name).'/view.tsx'));
        $this->components->info(sprintf('%s [%s] created successfully.', 'React component', $filePath));
    }
}
