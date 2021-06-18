<?php

namespace Helldar\LaravelLangPublisher\Support;

use ReflectionClass;

final class Reflection
{
    /**
     * @throws \ReflectionException
     */
    public function getConstants(string $class): array
    {
        return $this->resolve($class)->getConstants();
    }

    /**
     * @throws \ReflectionException
     */
    protected function resolve(string $class): ReflectionClass
    {
        return new ReflectionClass($class);
    }
}
