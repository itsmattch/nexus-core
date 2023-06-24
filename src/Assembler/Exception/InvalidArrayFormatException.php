<?php

namespace Itsmattch\Nexus\Assembler\Exception;

use Exception;

class InvalidArrayFormatException extends Exception
{
    public function __construct()
    {
        parent::__construct("Resources and blueprints must be indexed arrays.");
    }
}