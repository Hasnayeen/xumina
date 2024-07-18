<?php

namespace Hasnayeen\Xumina\Commands\Concerns;

use Illuminate\Support\Facades\File;

trait InteractWithFileSystem
{
    public function ensureDirectoryExists(string $filePath): bool
    {
        if ($this->directoryExists($filePath)) {
            return true;
        }

        return File::makeDirectory($filePath, force: true);
    }

    public function directoryExists(string $filePath): bool
    {
        return File::exists($filePath);
    }

    protected function replaceInFile(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
