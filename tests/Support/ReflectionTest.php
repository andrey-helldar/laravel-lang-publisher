<?php

namespace Tests\Support;

use Helldar\LaravelLangPublisher\Constants\Config;
use Helldar\LaravelLangPublisher\Constants\Locales;
use Helldar\LaravelLangPublisher\Constants\Status;
use Helldar\LaravelLangPublisher\Support\Reflection;
use Tests\TestCase;

final class ReflectionTest extends TestCase
{
    public function testGetConstantsConfig()
    {
        $expected = [
            'KEY_PUBLIC'  => 'lang-publisher',
            'KEY_PRIVATE' => 'lang-publisher-private',
        ];

        $this->same(Config::class, $expected);
    }

    public function testGetConstantsLocales()
    {
        $expected = [
            'AFRIKAANS'           => 'af',
            'ALBANIAN'            => 'sq',
            'ARABIC'              => 'ar',
            'ARMENIAN'            => 'hy',
            'AZERBAIJANI'         => 'az',
            'BASQUE'              => 'eu',
            'BELARUSIAN'          => 'be',
            'BENGALI'             => 'bn',
            'BOSNIAN'             => 'bs',
            'BULGARIAN'           => 'bg',
            'CATALAN'             => 'ca',
            'CENTRAL_KHMER'       => 'km',
            'CHINESE'             => 'zh_CN',
            'CHINESE_HONG_KONG'   => 'zh_HK',
            'CHINESE_T'           => 'zh_TW',
            'CROATIAN'            => 'hr',
            'CZECH'               => 'cs',
            'DANISH'              => 'da',
            'DUTCH'               => 'nl',
            'ENGLISH'             => 'en',
            'ESTONIAN'            => 'et',
            'FINNISH'             => 'fi',
            'FRENCH'              => 'fr',
            'GALICIAN'            => 'gl',
            'GEORGIAN'            => 'ka',
            'GERMAN'              => 'de',
            'GERMAN_SWITZERLAND'  => 'de_CH',
            'GREEK'               => 'el',
            'HEBREW'              => 'he',
            'HINDI'               => 'hi',
            'HUNGARIAN'           => 'hu',
            'ICELANDIC'           => 'is',
            'INDONESIAN'          => 'id',
            'ITALIAN'             => 'it',
            'JAPANESE'            => 'ja',
            'KANNADA'             => 'kn',
            'KAZAKH'              => 'kk',
            'KOREAN'              => 'ko',
            'LATVIAN'             => 'lv',
            'LITHUANIAN'          => 'lt',
            'MACEDONIAN'          => 'mk',
            'MALAY'               => 'ms',
            'MARATHI'             => 'mr',
            'MONGOLIAN'           => 'mn',
            'NEPALI'              => 'ne',
            'NORWEGIAN_BOKMAL'    => 'nb',
            'NORWEGIAN_NYNORSK'   => 'nn',
            'OCCITAN'             => 'oc',
            'PASHTO'              => 'ps',
            'PERSIAN'             => 'fa',
            'PILIPINO'            => 'fil',
            'POLISH'              => 'pl',
            'PORTUGUESE'          => 'pt',
            'PORTUGUESE_BRAZIL'   => 'pt_BR',
            'ROMANIAN'            => 'ro',
            'RUSSIAN'             => 'ru',
            'SARDINIAN'           => 'sc',
            'SERBIAN_CYRILLIC'    => 'sr_Cyrl',
            'SERBIAN_LATIN'       => 'sr_Latn',
            'SERBIAN_MONTENEGRIN' => 'sr_Latn_ME',
            'SINHALA'             => 'si',
            'SLOVAK'              => 'sk',
            'SLOVENIAN'           => 'sl',
            'SPANISH'             => 'es',
            'SWAHILI'             => 'sw',
            'SWEDISH'             => 'sv',
            'TAGALOG'             => 'tl',
            'TAJIK'               => 'tg',
            'THAI'                => 'th',
            'TURKISH'             => 'tr',
            'TURKMEN'             => 'tk',
            'UIGHUR'              => 'ug',
            'UKRAINIAN'           => 'uk',
            'URDU'                => 'ur',
            'UZBEK_CYRILLIC'      => 'uz_Cyrl',
            'UZBEK_LATIN'         => 'uz_Latn',
            'VIETNAMESE'          => 'vi',
            'WELSH'               => 'cy',
        ];

        $this->same(Locales::class, $expected);
    }

    public function testGetConstantsStatus()
    {
        $expected = [
            'COPIED'    => 'copied',
            'DELETED'   => 'deleted',
            'NOT_FOUND' => 'not found',
            'RESET'     => 'reset',
            'SKIPPED'   => 'skipped',
        ];

        $this->same(Status::class, $expected);
    }

    protected function same(string $class, array $expected): void
    {
        $constants = $this->resolve()->getConstants($class);

        $this->assertSame($expected, $constants, 'Incorrect content of class constants: ' . $class);
    }

    protected function resolve(): Reflection
    {
        return new Reflection();
    }
}
