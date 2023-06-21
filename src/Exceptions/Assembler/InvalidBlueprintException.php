<?php

namespace Itsmattch\Nexus\Exceptions\Assembler;

use Exception;

class InvalidBlueprintException extends Exception
{
    public function __construct()
    {
        parent::__construct("All blueprints must be subclasses of Blueprint.");
    }
}