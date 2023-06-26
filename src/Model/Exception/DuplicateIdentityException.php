<?php

namespace Itsmattch\Nexus\Model\Exception;

use Exception;

class DuplicateIdentityException extends Exception
{
    public function __construct(string $model, string $badge)
    {
        parent::__construct("Identity with the '$badge' badge already exists in '$model'.");
    }
}