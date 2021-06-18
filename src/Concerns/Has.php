<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Facades\Helpers\Str;

trait Has
{
    protected function hasJson(string $filename): bool
    {
        $extension = Path::extension($filename);

        return Str::lower($extension) === 'json';
    }
}
