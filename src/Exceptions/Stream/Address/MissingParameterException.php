<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Address;

use Exception;

class MissingParameterException extends Exception
{
    public function __construct(string $parameterName)
    {
        parent::__construct("Failed to set the value. Parameter '$parameterName' is missing in the parameters collection.");
    }
}