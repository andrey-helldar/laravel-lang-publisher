<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\PrettyArray\Contracts\Caseable;
use Illuminate\Support\Facades\Config as Illuminate;

final class Config
{
    use Logger;

    public const KEY_PRIVATE = 'lang-publisher-private';

    public const KEY_PUBLIC = 'lang-publisher';

    /**
     * Getting a list of packages from which to synchronize localization files.
     *
     * @return array
     */
    public function packages(): array
    {
        $this->log('Getting a list of supported packages...');

        $private = Illuminate::get(self::KEY_PRIVATE . '.packages', []);
        $public  = Illuminate::get(self::KEY_PUBLIC . '.packages', []);

        return array_values(array_merge($public, $private));
    }

    public function plugins(): array
    {
        $this->log('Getting a list of supported plugins...');

        $private = Illuminate::get(self::KEY_PRIVATE . '.plugins', []);
        $public  = Illuminate::get(self::KEY_PUBLIC . '.plugins', []);

        return array_values(array_merge($public, $private));
    }

    /**
     * Retrieving a link to the "vendor" directory.
     *
     * @return string
     */
    public function basePath(): string
    {
        $this->log('Retrieving a link to the "vendor" directory...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.base');
    }

    /**
     * Getting the name of the directory with the source files of the English localization.
     *
     * @return string
     */
    public function sourcePath(): string
    {
        $this->log('Getting the name of the directory with the source files of the English localization...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.source');
    }

    /**
     * Getting the path to localizations.
     *
     * @return string
     */
    public function localesPath(): string
    {
        $this->log('Getting the path to localizations...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.locales');
    }

    /**
     * Getting the path to resources of the application.
     *
     * @return string
     */
    public function resourcesPath(): string
    {
        $this->log('Getting the path to resources of the application...');

        return Illuminate::get(self::KEY_PRIVATE . '.path.target');
    }

    /**
     * Determines what type of files to use when updating language files.
     *
     * @return bool
     */
    public function hasInline(): bool
    {
        $this->log('Determines what type of files to use when updating language files...');

        return Illuminate::get(self::KEY_PUBLIC . '.inline');
    }

    /**
     * Determines whether values should be aligned when saving.
     *
     * @return bool
     */
    public function hasAlignment(): bool
    {
        $this->log('Determines whether values should be aligned when saving...');

        return Illuminate::get(self::KEY_PUBLIC . '.alignment');
    }

    /**
     * Key exclusion when combining.
     *
     * @return array
     */
    public function excludes(): array
    {
        $this->log('Key exclusion when combining...');

        return Illuminate::get(self::KEY_PUBLIC . '.exclude', []);
    }

    /**
     * List of ignored localizations.
     *
     * @return array
     */
    public function ignores(): array
    {
        $this->log('List of ignored localizations...');

        return Illuminate::get(self::KEY_PUBLIC . '.ignore', []);
    }

    /**
     * Getting the value of the option to change the case of keys.
     *
     * @return int
     */
    public function getCase(): int
    {
        $this->log('Getting the value of the option to change the case of keys...');

        return Illuminate::get(self::KEY_PUBLIC . '.case', Caseable::NO_CASE);
    }

    /**
     * Getting the default localization name.
     *
     * @return string
     */
    public function defaultLocale(): string
    {
        $this->log('Getting the default localization name...');

        return Illuminate::get('app.locale') ?: $this->fallbackLocale();
    }

    /**
     * Getting the fallback localization name.
     *
     * @return string
     */
    public function fallbackLocale(): string
    {
        $this->log('Getting the fallback localization name...');

        return Illuminate::get('app.fallback_locale') ?: LocalesList::ENGLISH;
    }
}
