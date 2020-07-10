<?php

namespace Helldar\LaravelLangPublisher\Exceptions;

use RuntimeException;

final class SourceLocaleNotExists extends RuntimeException
{
    public function __construct(string $locale)
    {
        parent::__construct("The source directory for \"{$locale}\" localization was not found.");
    }
}
