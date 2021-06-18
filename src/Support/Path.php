<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Facades\Config as ConfigSupport;

final class Path
{
    public function basename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_BASENAME);
    }

    public function filename(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    public function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public function vendor(string $path): string
    {
        $vendor = ConfigSupport::vendor();

        return $this->clean($vendor, $path);
    }

    protected function clean(...$values): string
    {
        foreach ($values as &$value) {
            $value = trim($value, " \t\n\r\0\x0B\\/");
        }

        return implode('/', $values);
    }
}
