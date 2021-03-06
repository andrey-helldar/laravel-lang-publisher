<?php

namespace Helldar\LaravelLangPublisher\Services\Command;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @method static Locales make(InputInterface $input, OutputStyle $output, Actionable $action, array $locales)
 */
final class Locales
{
    use Logger;
    use Makeable;

    protected $input;

    protected $output;

    protected $action;

    protected $locales = [];

    protected $select_template = 'What languages to %s? (specify the necessary localizations separated by commas)';

    protected $select_all_template = 'Do you want to %s all localizations?';

    public function __construct(InputInterface $input, OutputStyle $output, Actionable $action, array $locales)
    {
        $this->log('Object initialization:', self::class);

        $this->input   = $input;
        $this->output  = $output;
        $this->action  = $action;
        $this->locales = $locales;
    }

    public function get(): array
    {
        $this->log('Getting a list of localizations...');

        $input = $this->input();

        if ($this->hasAll($input) && $this->confirm()) {
            $this->log('Returning a list of all localizations...');

            return $this->locales;
        }

        if (! empty($input)) {
            $this->log('Returning a input list of localizations...');

            return $this->correctLocalesList($input);
        }

        $this->log('Asking what localizations need to be done...');

        return $this->correctLocalesList($this->select());
    }

    protected function select(): array
    {
        $this->log('Displaying an interactive question with a choice of localizations...');

        $locales = null;

        while (! $locales) {
            $locales = $this->ask();
        }

        return $locales;
    }

    protected function confirm(): bool
    {
        $this->log('Confirmation of processing of all localizations...');

        return $this->output->confirm($this->confirmQuestion());
    }

    protected function ask(): ?array
    {
        $this->log('Localization selection request...');

        return (array) $this->output->choice($this->choiceQuestion(), $this->locales);
    }

    protected function input(): array
    {
        $this->log('Getting a list of localizations from arguments...');

        return (array) $this->input->getArgument('locales');
    }

    protected function choiceQuestion(): string
    {
        return sprintf($this->select_template, $this->action->future());
    }

    protected function confirmQuestion(): string
    {
        return sprintf($this->select_all_template, $this->action->future());
    }

    protected function correctLocalesList(array $locales): array
    {
        $this->log('Correction of the array of localizations...');

        return $this->hasAll($locales) ? $this->locales : $locales;
    }

    protected function hasAll(array $locales): bool
    {
        $this->log('Checking for occurrence of the return character of all localizations...');

        return in_array('*', $locales, true) || empty($locales);
    }
}
