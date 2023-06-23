<?php

namespace Itsmattch\Nexus\Exceptions\Common;

use Exception;

class InvalidWriterException extends Exception
{
    public function __construct(string $writer)
    {
        parent::__construct("The provided writer '$writer' must be a subclass of Writer.");
    }
}