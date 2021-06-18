<?php

namespace Helldar\LaravelLangPublisher\Concerns;

use Helldar\Verbose\Facades\Log;
use Helldar\Verbose\Services\Logger as Service;

trait Logger
{
    protected function setLogger(): void
    {
        Service::io($this->output);
    }

    protected function log(...$message): void
    {
        $value = $this->logProcess($message);

        Log::write($value);
    }

    protected function logProcess(array $values): string
    {
        foreach ($values as &$value) {
            switch (gettype($value)) {
                case 'array':
                    $value = implode(', ', $value);
                    break;

                default:
                    $value = json_encode($value);
            }
        }

        return implode(' ', $values);
    }
}
