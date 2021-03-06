<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Facades\Arr as ArrFacade;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigFacade;
use Helldar\LaravelLangPublisher\Facades\Reflection as ReflectionFacade;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;

final class Locales
{
    use Logger;

    /**
     * List of available locations.
     *
     * @return array
     */
    public function available(): array
    {
        $this->log('Getting list of available locations.');

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
        $this->log('Getting list of installed locations...');

        $json = $this->findJsonFiles();
        $php  = $this->findPhpFiles();

        $installed = ArrFacade::unique(array_merge($json, $php));

        $sorted = Arr::sort($installed);

        return array_values($sorted);
    }

    /**
     * Retrieving a list of protected locales.
     *
     * @return array
     */
    public function protects(): array
    {
        $this->log('Retrieving a list of protected locales...');

        return ArrFacade::unique([
            $this->getDefault(),
            $this->getFallback(),
        ]);
    }

    /**
     * Getting a complete list of available localizations.
     *
     * @return array
     */
    public function all(): array
    {
        $this->log('Getting a list of all available localizations without filtering...');

        return array_values(ReflectionFacade::getConstants(LocalesList::class));
    }

    /**
     * Checks if a language pack is installed.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isAvailable(string $locale): bool
    {
        $this->log('Checks if a language pack is installed:', $locale);

        return in_array($locale, $this->all(), true);
    }

    /**
     * The checked locale protecting.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isProtected(string $locale): bool
    {
        $this->log('The checked locale protecting:', $locale);

        return $locale === $this->getDefault() || $locale === $this->getFallback();
    }

    /**
     * Checks whether it is possible to install the language pack.
     *
     * @param  string  $locale
     *
     * @return bool
     */
    public function isInstalled(string $locale): bool
    {
        $this->log('Checks whether it is possible to install the language pack:', $locale);

        return in_array($locale, $this->installed(), true);
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function getDefault(): string
    {
        $this->log('Getting the default localization name...');

        return ConfigFacade::defaultLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function getFallback(): string
    {
        $this->log('Getting the fallback localization name...');

        return ConfigFacade::fallbackLocale();
    }

    protected function filter(array $locales): array
    {
        $this->log('Filtering localizations...');

        $unique = ArrFacade::unique($locales);
        $ignore = ConfigFacade::ignores();

        return array_values(array_filter($unique, static function ($locale) use ($ignore) {
            return ! in_array($locale, $ignore, true);
        }));
    }

    protected function findJsonFiles(): array
    {
        $this->log('Getting a list of localizations from json files...');

        $files = File::names($this->resourcesPath());

        return Arr::map($files, static function ($filename) {
            return Str::before($filename, '.');
        });
    }

    protected function findPhpFiles(): array
    {
        $this->log('Getting a list of localizations from php files...');

        return Directory::names($this->resourcesPath(), static function ($name) {
            return ! in_array($name, ['spark', 'vendor'], true);
        });
    }

    protected function resourcesPath(): string
    {
        $this->log('Getting the path to application resources...');

        return ConfigFacade::resourcesPath();
    }
}
