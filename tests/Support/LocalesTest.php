<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Constants\Locales as LocalesList;
use Helldar\LaravelLangPublisher\Support\Locales;
use Tests\TestCase;

final class LocalesTest extends TestCase
{
    public function testIsInstalled()
    {
        $this->assertTrue($this->resolve()->isInstalled(LocalesList::ENGLISH));
        $this->assertTrue($this->resolve()->isInstalled(LocalesList::KOREAN));

        $this->assertFalse($this->resolve()->isInstalled(LocalesList::FRENCH));
        $this->assertFalse($this->resolve()->isInstalled(LocalesList::GERMAN));
        $this->assertFalse($this->resolve()->isInstalled(LocalesList::RUSSIAN));
    }

    public function testGetDefault()
    {
        $actual = $this->resolve()->getDefault();

        $expected = LocalesList::ENGLISH;

        $this->assertSame($expected, $actual);
    }

    public function testIsProtected()
    {
        $this->assertTrue($this->resolve()->isProtected(LocalesList::ENGLISH));
        $this->assertTrue($this->resolve()->isProtected(LocalesList::KOREAN));

        $this->assertFalse($this->resolve()->isProtected(LocalesList::FRENCH));
        $this->assertFalse($this->resolve()->isProtected(LocalesList::GERMAN));
        $this->assertFalse($this->resolve()->isProtected(LocalesList::RUSSIAN));
    }

    public function testAvailable()
    {
        $actual = $this->resolve()->available();

        $expected = [
            'af',
            'ar',
            'az',
            'be',
            'bg',
            'bn',
            'bs',
            'cs',
            'cy',
            'da',
            'de',
            'de_CH',
            'el',
            'en',
            'es',
            'et',
            'eu',
            'fa',
            'fi',
            'fil',
            'fr',
            'he',
            'hi',
            'hr',
            'hu',
            'hy',
            'id',
            'is',
            'it',
            'ja',
            'ka',
            'kk',
            'km',
            'kn',
            'ko',
            'lt',
            'lv',
            'mk',
            'mn',
            'mr',
            'ms',
            'nb',
            'ne',
            'nl',
            'nn',
            'oc',
            'pl',
            'ps',
            'pt',
            'pt_BR',
            'ro',
            'ru',
            'sc',
            'si',
            'sk',
            'sl',
            'sq',
            'sr_Cyrl',
            'sr_Latn',
            'sr_Latn_ME',
            'sv',
            'sw',
            'tg',
            'th',
            'tk',
            'tl',
            'tr',
            'ug',
            'uk',
            'ur',
            'uz_Cyrl',
            'uz_Latn',
            'vi',
            'zh_CN',
            'zh_HK',
            'zh_TW',
        ];

        $this->assertSame($expected, $actual);
    }

    public function testIsAvailable()
    {
        $this->assertTrue($this->resolve()->isAvailable(LocalesList::ENGLISH));
        $this->assertTrue($this->resolve()->isAvailable(LocalesList::KOREAN));

        $this->assertFalse($this->resolve()->isAvailable('foo'));
        $this->assertFalse($this->resolve()->isAvailable('bar'));
        $this->assertFalse($this->resolve()->isAvailable('baz'));
    }

    public function testProtects()
    {
        $actual = $this->resolve()->protects();

        $expected = [
            LocalesList::ENGLISH,
            LocalesList::KOREAN,
        ];

        $this->assertSame($expected, $actual);
    }

    public function testInstalled()
    {
        $expected1 = [
            LocalesList::ENGLISH,
            LocalesList::KOREAN,
        ];

        $expected2 = [
            LocalesList::BULGARIAN,
            LocalesList::DANISH,
            LocalesList::ENGLISH,
            LocalesList::GALICIAN,
            LocalesList::ICELANDIC,
            LocalesList::KOREAN,
        ];

        $this->assertSame($expected1, $this->resolve()->installed());

        // insall

        $this->assertSame($expected2, $this->resolve()->installed());
    }

    public function testAll()
    {
        $actual = $this->resolve()->all();

        $expected = [
            'af',
            'ar',
            'az',
            'be',
            'bg',
            'bn',
            'bs',
            'ca',
            'cs',
            'cy',
            'da',
            'de',
            'de_CH',
            'el',
            'en',
            'es',
            'et',
            'eu',
            'fa',
            'fi',
            'fil',
            'fr',
            'gl',
            'he',
            'hi',
            'hr',
            'hu',
            'hy',
            'id',
            'is',
            'it',
            'ja',
            'ka',
            'kk',
            'km',
            'kn',
            'ko',
            'lt',
            'lv',
            'mk',
            'mn',
            'mr',
            'ms',
            'nb',
            'ne',
            'nl',
            'nn',
            'oc',
            'pl',
            'ps',
            'pt',
            'pt_BR',
            'ro',
            'ru',
            'sc',
            'si',
            'sk',
            'sl',
            'sq',
            'sr_Cyrl',
            'sr_Latn',
            'sr_Latn_ME',
            'sv',
            'sw',
            'tg',
            'th',
            'tk',
            'tl',
            'tr',
            'ug',
            'uk',
            'ur',
            'uz_Cyrl',
            'uz_Latn',
            'vi',
            'zh_CN',
            'zh_HK',
            'zh_TW',
        ];

        $this->assertSame($expected, $actual);
    }

    public function testGetFallback()
    {
        $actual = $this->resolve()->getFallback();

        $expected = LocalesList::KOREAN;

        $this->assertSame($expected, $actual);
    }

    protected function resolve(): Locales
    {
        return new Locales();
    }
}
