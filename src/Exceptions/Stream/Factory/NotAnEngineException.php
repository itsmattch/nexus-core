<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Factory;

use Exception;

class NotAnEngineException extends Exception
{
    public function __construct(string $engine)
    {
        parent::__construct("The provided engine '{$engine}' must be a subclass of Engine.");
    }
}