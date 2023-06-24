<?php

namespace Itsmattch\Nexus\Assembler\Exception;

use Exception;

class InvalidResourceException extends Exception
{
    public function __construct()
    {
        parent::__construct("All resources must be subclasses of Resource.");
    }
}