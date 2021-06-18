<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\LaravelLangPublisher\Facades\Path;

trait Pathable
{
    protected function pathVendor(string $path = null): string
    {
        $this->log('Getting the vendor path.');

        return Path::vendor($path);
    }
}
