<?php

namespace Itsmattch\Nexus\Exceptions\Common;

use Exception;

class InvalidReaderException extends Exception
{
    public function __construct(string $reader)
    {
        parent::__construct("The provided reader '$reader' must be a subclass of Reader.");
    }
}