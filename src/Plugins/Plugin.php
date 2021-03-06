<?php

namespace Helldar\LaravelLangPublisher\Plugins;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Plugin as Contract;
use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

abstract class Plugin implements Contract
{
    use Contains;
    use Logger;
    use Makeable;

    public function target(): ?string
    {
        return null;
    }

    public function has(): bool
    {
        $this->log('Check if the package is installed:', $this->vendor());

        $source = $this->basePath() . '/' . $this->vendor();

        return Directory::exists($source);
    }

    public function targetPath(string $locale, string $filename): string
    {
        $this->log('Getting a link to the target file for:', $filename, '(', $locale, ')');

        $path = $this->resolveTargetPath($locale, $filename);

        $target = $this->targetFilename($locale, $filename);

        return $this->cleanPath($path . '/' . $target);
    }

    protected function targetFilename(string $locale, string $filename): string
    {
        $this->log('Retrieving the changed filename:', $filename, '(', $locale, ')');

        if ($this->isJson($filename)) {
            return $locale . '.json';
        }

        return $this->fileBasename($filename);
    }

    protected function basePath(): string
    {
        return Config::basePath();
    }

    protected function fileBasename(string $filename): string
    {
        return Path::basename($filename);
    }

    protected function cleanPath(?string $path): ?string
    {
        return Path::clean($path, true);
    }

    protected function resolveTargetPath(string $locale, string $filename): ?string
    {
        $this->log('Resolving the path to the target file:', $filename, '(', $locale, ')');

        $path = $this->cleanPath($this->target());

        if ($this->isPhp($filename)) {
            $path .= '/' . $locale;
        }

        return $this->cleanPath($path);
    }
}
