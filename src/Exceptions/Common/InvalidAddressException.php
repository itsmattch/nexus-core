<?php

namespace Itsmattch\Nexus\Exceptions\Common;

use Exception;

class InvalidAddressException extends Exception
{
    public function __construct(string $address)
    {
        parent::__construct("The provided address '$address' must be a subclass of Address or a URL-style string.");
    }
}