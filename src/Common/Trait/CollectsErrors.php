<?php

namespace Itsmattch\Nexus\Common\Trait;

trait CollectsErrors
{
    protected array $errors = [];

    protected function addError(string $error): void
    {
        $errorContainer = $error;
        $this->errors[] = $errorContainer;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}