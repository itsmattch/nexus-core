<?php

namespace Itsmattch\Nexus\Common\Trait;

use Exception;

trait CollectsExceptions
{
    protected array $exceptions = [];

    protected function addException(Exception $exception): void
    {
        $this->exceptions[] = $exception;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}