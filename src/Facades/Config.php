<?php

namespace Helldar\LaravelLangPublisher\Facades;

use Helldar\LaravelLangPublisher\Support\Config as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array excludes()
 * @method static array ignores()
 * @method static array packages()
 * @method static array plugins()
 * @method static bool hasAlignment()
 * @method static bool hasInline()
 * @method static int getCase()
 * @method static string defaultLocale()
 * @method static string fallbackLocale()
 * @method static string locales()
 * @method static string resources()
 * @method static string source()
 * @method static string vendor()
 */
final class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
