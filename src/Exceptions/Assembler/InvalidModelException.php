<?php

namespace Itsmattch\Nexus\Exceptions\Assembler;

use Exception;

class InvalidModelException extends Exception
{
    public function __construct(string $model)
    {
        parent::__construct("The provided model '{$model}' must be a subclass of Model.");
    }
}