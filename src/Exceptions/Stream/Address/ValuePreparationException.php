<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Address;

use Exception;

class ValuePreparationException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Failed to prepare the value for use as a parameter. The value of type '{$type}' was provided, but it results in an empty string when processed.");
    }
}