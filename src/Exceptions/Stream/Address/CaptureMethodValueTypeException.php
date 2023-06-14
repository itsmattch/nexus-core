<?php

namespace Itsmattch\Nexus\Exceptions\Stream\Address;

use Exception;
use TypeError;

class CaptureMethodValueTypeException extends Exception
{
    public function __construct(TypeError $e)
    {
        parent::__construct($e->getMessage());
    }
}