<?php

namespace Itsmattch\Nexus\Assembler\Exception;

use Exception;

class BlueprintCountException extends Exception
{
    public function __construct()
    {
        parent::__construct("Count of blueprint must be 1 or equal to the count of resources.");
    }
}