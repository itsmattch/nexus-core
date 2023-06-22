<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Address;

use Exception;

class DynamicMethodMissingValueException extends Exception
{
    public function __construct(string $method)
    {
        parent::__construct("Failed to call dynamic method '$method'. The method requires at least one argument, but none were provided.");
    }
}