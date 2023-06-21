<?php

namespace Itsmattch\Nexus\Exceptions\Resource\Address;

use Exception;

class UncaughtDynamicMethodException extends Exception
{
    public function __construct(string $methodName)
    {
        parent::__construct("Failed to call dynamic method. Method '$methodName' does not exist or is not accessible.");
    }
}