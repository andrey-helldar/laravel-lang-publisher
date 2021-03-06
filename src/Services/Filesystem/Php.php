<?php

namespace Helldar\LaravelLangPublisher\Services\Filesystem;

use Helldar\LaravelLangPublisher\Facades\Config;
use Helldar\PrettyArray\Services\File as Pretty;
use Helldar\PrettyArray\Services\Formatter;

final class Php extends Filesystem
{
    public function load(string $path): array
    {
        $this->log('Loading the contents of the file:', $path);

        if ($this->doesntExists($path)) {
            $this->log('File not found:', $path);

            return [];
        }

        $this->log('Loading data from a file:', $path);

        $items = Pretty::make()->load($path);

        return $this->correctValues($items);
    }

    public function store(string $path, array $content)
    {
        $this->log('Saving an array to a file:', $path);

        $service = Formatter::make();

        $this->setFormatterCase($service);
        $this->setFormatterAlignment($service);
        $this->setFormatterKeyToString($service);

        Pretty::make($service->raw($content))->store($path);
    }

    protected function isAlignment(): bool
    {
        return Config::hasAlignment();
    }

    protected function setFormatterCase(Formatter $formatter): void
    {
        $this->log('Setting the key conversion label.');

        $formatter->setCase(Config::getCase());
    }

    protected function setFormatterAlignment(Formatter $formatter): void
    {
        $this->log('Setting the alignment label of values.');

        if ($this->isAlignment()) {
            $formatter->setEqualsAlign();
        }
    }

    protected function setFormatterKeyToString(Formatter $formatter): void
    {
        $this->log('Setting the label for converting numeric keys to string...');

        $formatter->setKeyAsString();
    }
}
