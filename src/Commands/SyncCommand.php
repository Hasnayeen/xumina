<?php

namespace Hasnayeen\Xumina\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\confirm;

#[AsCommand(name: 'xumina:sync')]
class SyncCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'xumina:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync xumina react components from package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ((new Filesystem)->isDirectory(resource_path('js/xumina'))) {
            $overwrite = confirm('This will replace existing files, are you sure?', true);
            if (! $overwrite) {
                $this->components->error('Aborting!');

                return 1;
            }
        }
        (new Filesystem)->deleteDirectory(resource_path('js/xumina'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/xumina'));
        (new Filesystem)->copyDirectory(base_path('vendor/hasnayeen/xumina/resources/js'), resource_path('js/xumina'));

        $this->components->info('Components have been synced.');
    }
}
