<?php

namespace Itsmattch\Nexus\Exceptions\Resource\Factory;

use Exception;

class InvalidEngineException extends Exception
{
    public function __construct(string $engine)
    {
        parent::__construct("The provided engine '$engine' must be a subclass of Engine.");
    }
}