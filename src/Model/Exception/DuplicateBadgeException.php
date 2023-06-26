<?php

namespace Itsmattch\Nexus\Model\Exception;

use Exception;

class DuplicateBadgeException extends Exception
{
    public function __construct(string $badge, string $model)
    {
        parent::__construct("Badge '$badge' already exists in '$model'.");
    }
}