<?php

namespace Helldar\LaravelLangPublisher\Services\Comparators;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Comparator as ComparatorContract;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Concerns\Makeable;

final class Manage
{
    use Contains;
    use Keyable;
    use Logger;
    use Makeable;

    protected $source;

    protected $target;

    protected $filename;

    protected $full = false;

    protected $key;

    public function source(array $array): self
    {
        $this->source = $array;

        return $this;
    }

    public function target(array $array): self
    {
        $this->target = $array;

        return $this;
    }

    public function filename(string $filename): self
    {
        $this->filename = Path::filename($filename);
        $this->key      = $this->key($filename);

        return $this;
    }

    public function full(bool $full): self
    {
        $this->full = $full;

        return $this;
    }

    public function find(): ComparatorContract
    {
        $this->log('Comparison object definition...');

        return $this->resolve()
            ->full($this->full)
            ->key($this->key)
            ->source($this->source)
            ->target($this->target);
    }

    protected function resolve(): ComparatorContract
    {
        $this->log('Comparison object resolve...');

        return $this->isValidation($this->filename) ? Validation::make() : Basic::make();
    }
}
