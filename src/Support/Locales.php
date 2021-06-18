<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Has;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigSupport;
use Helldar\LaravelLangPublisher\Facades\Path as PathSupport;
use Helldar\LaravelLangPublisher\Facades\Reflection as ReflectionSupport;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;

final class Locales
{
    use Has;

    /**
     * List of available locations.
     *
     * @return array
     */
    public function available(): array
    {
        $locales = $this->all();

        return $this->filter($locales);
    }

    /**
     * List of installed locations.
     *
     * @return array
     */
    public function installed(): array
    {
        return Arrayable::of()
            ->merge($this->findJson(), $this->findPhp())
            ->filter(function ($locale) {
                return $this->isAvailable($locale);
            })
            ->unique()
            ->sort()
            ->values()
            ->get();
    }

    /**
     * Retrieving a list of protected locales.
     *
     * @return array
     */
    public function protects(): array
    {
        return Arrayable::of([
            $this->getDefault(),
            $this->getFallback(),
        ])
            ->unique()
            ->get();
    }

    /**
     * Getting a complete list of available localizations.
     *
     * @return array
     */
    public function all(): array
    {
        $locales = ReflectionSupport::getConstants(LocalesList::class);

        return Arrayable::of($locales)
            ->sort()
            ->values()
            ->get();
    }

    /**
     * Checks if a localization is available.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isAvailable(string $locale): bool
    {
        return $this->in($locale, $this->available());
    }

    /**
     * Checks if a localization is protected.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isProtected(string $locale): bool
    {
        return $this->in($locale, $this->protects());
    }

    /**
     * Checks if a localization is installed.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isInstalled(string $locale): bool
    {
        return $this->in($locale, $this->installed());
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function getDefault(): string
    {
        return ConfigSupport::defaultLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function getFallback(): string
    {
        return ConfigSupport::fallbackLocale();
    }

    protected function filter(array $locales): array
    {
        $ignores = ConfigSupport::ignores();

        return Arrayable::of($locales)
            ->unique()
            ->filter(function ($locale) use ($ignores) {
                return $this->isProtected($locale) || ! $this->in($locale, $ignores);
            })
            ->values()
            ->get();
    }

    protected function in(string $locale, array $locales): bool
    {
        return in_array($locale, $locales, true);
    }

    protected function findJson(): array
    {
        $files = File::names($this->resourcesPath(), null, true);

        return Arrayable::of($files)
            ->filter(function (string $filename) {
                return $this->hasJson($filename);
            })
            ->map(static function (string $filename) {
                return PathSupport::filename($filename);
            })
            ->get();
    }

    protected function findPhp(): array
    {
        return Directory::names($this->resourcesPath());
    }

    protected function resourcesPath(): string
    {
        return ConfigSupport::resources();
    }
}
