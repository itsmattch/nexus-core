<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Factory;

use Exception;

class ReaderNotFoundException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("No reader registered for the '$type' type.");
    }
}