<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Address;

class DynamicMethodMissingValueException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Failed to call dynamic method. The method requires at least one argument, but none were provided.");
    }
}