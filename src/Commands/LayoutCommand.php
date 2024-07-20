<?php

namespace Hasnayeen\Xumina\Commands;

use Hasnayeen\Xumina\Commands\Concerns\InteractWithFileSystem;
use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Panel;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

#[AsCommand(name: 'xumina:layout')]
class LayoutCommand extends Command implements PromptsForMissingInput
{
    use InteractWithFileSystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xumina:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new layout';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $panel = select(
            'Which panel you want to create the resource?',
            Xumina::getPanels()->transform(fn(Panel $panel) => Str::studly($panel->getName())),
        );
        $name = text(
            label: 'Name of the Layout?',
            placeholder: 'MyAwesomeLayout',
            required: true,
        );
        $this->ensureDirectoryExists(app_path('Xumina/' . $panel . '/Layouts'));
        if (File::exists(app_path('Xumina/' . $panel . '/Layouts/' . Str::studly($name)))) {
            $overwrite = confirm(
                label: "A layout named {$name} already exists, overwrite?",
                default: false,
            );
            if (! $overwrite) {
                $this->components->error('Layout already exists. Aborting!');

                return 1;
            }
        }

        File::copy(__DIR__ . '/../../stubs/app/Xumina/Layouts/Layout.php', $filePath = app_path('Xumina/' . $panel . '/Layouts/' . Str::studly($name) . '.php'));
        $this->replaceInFile('{{ $panel }}', $panel, $filePath);
        $this->replaceInFile('{{ $name }}', Str::studly($name), $filePath);
        $this->components->info(sprintf('%s [%s] created successfully.', 'Layout', $filePath));
    }
}
