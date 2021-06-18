<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Concerns\Pathable;
use Helldar\LaravelLangPublisher\Constants\Config;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Facades\Config as ConfigSupport;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Pathable;
    use Logger;

    protected $default_locale = Locales::ENGLISH;

    protected $fallback_locale = Locales::KOREAN;

    protected $emulate = [
        'laravel/breeze',
        'laravel/fortify',
        'laravel/jetstream',
        'laravel/cashier',
        'laravel/nova',
        'laravel/spark-paddle',
        'laravel/spark-stripe',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshLocales();

        $this->emulatePackages();
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default_locale);
        $config->set('app.fallback_locale', $this->fallback_locale);

        $config->set(Config::KEY_PRIVATE . '.path.base', realpath(__DIR__ . '/../vendor'));

        $config->set(Config::KEY_PUBLIC . '.exclude', [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ]);

        $config->set(Config::KEY_PUBLIC . '.ignore', [
            Locales::CATALAN,
            Locales::GALICIAN,
        ]);

        $config->set(Config::KEY_PUBLIC . '.packages', [
            'andrey-helldar/lang-translations',
        ]);
    }

    protected function copyFixtures(): void
    {
        $files = [
            'en.json',
            'auth.php',
            'validation.php',
        ];

        foreach ($files as $filename) {
            File::copy(realpath(__DIR__ . '/fixtures/' . $filename), $this->path($this->default_locale, $filename));
        }
    }

    protected function refreshLocales(): void
    {
        $this->deleteLocales();
        $this->installLocales();
    }

    protected function deleteLocales(): void
    {
        $path = ConfigSupport::resources();

        Directory::ensureDelete($path);
    }

    protected function installLocales(): void
    {
        Artisan::call('lang:add', [
            'locales' => [
                $this->default_locale,
                $this->fallback_locale,
            ],
            '--force' => true,
        ]);
    }

    protected function emulatePackages(): void
    {
        foreach ($this->emulate as $package) {
            Directory::ensureDirectory($this->pathVendor($package));
        }
    }

    protected function removeEmulatedPackages(): void
    {
        foreach ($this->emulate as $package) {
            $path = $this->pathVendor($package);

            Directory::ensureDelete($path);
        }
    }
}
