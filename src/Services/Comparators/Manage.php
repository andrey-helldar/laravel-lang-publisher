<?php

namespace Helldar\LaravelLangPublisher\Services\Comparators;

use Helldar\LaravelLangPublisher\Concerns\Contains;
use Helldar\LaravelLangPublisher\Contracts\Comparator as ComparatorContract;
use Helldar\LaravelLangPublisher\Facades\Path;
use Helldar\Support\Concerns\Makeable;

final class Manage
{
    use Contains;
    use Makeable;

    protected $source;

    protected $target;

    protected $filename;

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

        return $this;
    }

    public function find(): ComparatorContract
    {
        return $this->resolve()
            ->source($this->source)
            ->target($this->target);
    }

    protected function resolve(): ComparatorContract
    {
        return $this->isValidation($this->filename) ? Validation::make() : Basic::make();
    }
}