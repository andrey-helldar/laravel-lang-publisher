<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Plugins\Breeze;
use Helldar\LaravelLangPublisher\Plugins\Cashier;
use Helldar\LaravelLangPublisher\Plugins\Fortify;
use Helldar\LaravelLangPublisher\Plugins\Jetstream;
use Helldar\LaravelLangPublisher\Plugins\Laravel;
use Helldar\LaravelLangPublisher\Plugins\Lumen;
use Helldar\LaravelLangPublisher\Plugins\Nova;
use Helldar\LaravelLangPublisher\Plugins\SparkPaddle;
use Helldar\LaravelLangPublisher\Plugins\SparkStripe;
use Helldar\LaravelLangPublisher\Support\Config;
use Helldar\PrettyArray\Contracts\Caseable;
use Tests\TestCase;

final class ConfigTest extends TestCase
{
    public function testPackages()
    {
        $actual = $this->resolve()->packages();

        $expected = [
            'laravel-lang/lang',
            'andrey-helldar/lang-translations',
        ];

        $this->assertSame($expected, $actual);
    }

    public function testHasAlignment()
    {
        $actual = $this->resolve()->hasAlignment();

        $this->assertTrue($actual);
    }

    public function testResources()
    {
        $actual = $this->resolve()->resources();

        $expected = resource_path('lang');

        $this->assertSame($expected, $actual);
    }

    public function testDefaultLocale()
    {
        $actual = $this->resolve()->defaultLocale();

        $this->assertSame($this->default_locale, $actual);
    }

    public function testIgnores()
    {
        $actual = $this->resolve()->ignores();

        $expected = [
            Locales::CATALAN,
            Locales::GALICIAN,
        ];

        $this->assertSame($expected, $actual);
    }

    public function testExcludes()
    {
        $actual = $this->resolve()->excludes();

        $expected = [
            'auth' => ['failed'],
            'json' => ['All rights reserved.', 'Baz'],
        ];

        $this->assertSame($expected, $actual);
    }

    public function testHasInline()
    {
        $actual = $this->resolve()->hasInline();

        $this->assertTrue($actual);
    }

    public function testPlugins()
    {
        $actual = $this->resolve()->plugins();

        $expected = [
            Breeze::class,
            Cashier::class,
            Fortify::class,
            Jetstream::class,
            Laravel::class,
            Lumen::class,
            Nova::class,
            SparkPaddle::class,
            SparkStripe::class,
        ];

        $this->assertSame($expected, $actual);
    }

    public function testVendor()
    {
        $actual = $this->resolve()->vendor();

        $expected = realpath(__DIR__ . '/../../vendor');

        $this->assertSame($expected, $actual);
    }

    public function testLocales()
    {
        $actual = $this->resolve()->locales();

        $this->assertSame('locales', $actual);
    }

    public function testGetCase()
    {
        $actual = $this->resolve()->getCase();

        $this->assertIsNumeric($actual);
        $this->assertSame(Caseable::NO_CASE, $actual);
    }

    public function testSource()
    {
        $actual = $this->resolve()->source();

        $this->assertSame('source', $actual);
    }

    public function testFallbackLocale()
    {
        $actual = $this->resolve()->fallbackLocale();

        $this->assertSame($this->fallback_locale, $actual);
    }

    protected function resolve(): Config
    {
        return new Config();
    }
}
