<?php

namespace Itsmattch\Nexus\Address\Exception;

use Exception;

class InvalidSchemeException extends Exception
{
    public function __construct(string $scheme)
    {
        parent::__construct("Invalid scheme: '$scheme'. Scheme must start with a letter and can be followed by any combination of letters, digits, plus, period, or hyphen.");
    }
}