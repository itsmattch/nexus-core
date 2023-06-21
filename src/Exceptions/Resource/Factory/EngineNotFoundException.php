<?php

namespace Itsmattch\Nexus\Exceptions\Resource\Factory;

use Exception;

class EngineNotFoundException extends Exception
{
    public function __construct(string $scheme)
    {
        parent::__construct("No engine registered for the '$scheme' scheme.");
    }
}