<?php

namespace Helldar\LaravelLangPublisher\Console;

final class Add extends Base
{
    protected $signature = 'lang:add'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--f|force : Override exiting files}';

    protected $description = 'Install new localizations.';
}
