<?php

namespace Hasnayeen\Xumina\Commands\Concerns;

use Illuminate\Support\Facades\File;

trait InteractWithFileSystem
{
    public function checkPanelExistence(string $name): bool
    {
        return $this->folderExists($name);
    }

    public function folderExists(string $name): bool
    {
        return File::exists(app_path("Xumina/{$name}"));
    }

    protected function replaceInFile(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
