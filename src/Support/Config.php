<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Constants\Config as ConfigNames;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;

final class Config
{
    /**
     * Getting a list of packages from which to synchronize localization files.
     *
     * @return array
     */
    public function packages(): array
    {
        return $this->getList('packages');
    }

    /**
     * Getting a list of plugins from which to synchronize localization files.
     *
     * @return array
     */
    public function plugins(): array
    {
        return $this->getList('plugins');
    }

    public function vendor(): string
    {
        return Illuminate::get($this->privateKey() . '.path.base');
    }

    public function resources(): string
    {
        return Illuminate::get($this->privateKey() . '.path.target');
    }

    public function source(): string
    {
        return Illuminate::get($this->privateKey() . '.path.source');
    }

    public function locales(): string
    {
        return Illuminate::get($this->privateKey() . '.path.locales');
    }

    public function excludes(): array
    {
        return Illuminate::get($this->publicKey() . '.exclude', []);
    }

    public function ignores(): array
    {
        return Illuminate::get($this->publicKey() . '.ignore', []);
    }

    public function getCase(): int
    {
        return Illuminate::get($this->publicKey() . '.case', Caseable::NO_CASE);
    }

    public function defaultLocale(): string
    {
        return Illuminate::get('app.locale') ?: $this->fallbackLocale();
    }

    public function fallbackLocale(): string
    {
        return Illuminate::get('app.fallback_locale') ?: LocalesList::ENGLISH;
    }

    public function hasInline(): bool
    {
        return Illuminate::get($this->publicKey() . '.inline');
    }

    public function hasAlignment(): bool
    {
        return Illuminate::get($this->publicKey() . '.alignment');
    }

    protected function getList(string $key): array
    {
        $private = Illuminate::get($this->privateKey() . '.' . $key, []);
        $public  = Illuminate::get($this->publicKey() . '.' . $key, []);

        return array_values(array_merge($private, $public));
    }

    protected function privateKey(): string
    {
        return ConfigNames::KEY_PRIVATE;
    }

    protected function publicKey(): string
    {
        return ConfigNames::KEY_PUBLIC;
    }
}
