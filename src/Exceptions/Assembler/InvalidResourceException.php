<?php

namespace Itsmattch\Nexus\Exceptions\Assembler;

use Exception;

class InvalidResourceException extends Exception
{
    public function __construct()
    {
        parent::__construct("All resources must be subclasses of Resource.");
    }
}