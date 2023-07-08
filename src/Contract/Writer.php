<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Common\Message;

interface Writer
{
    /** todo */
    public function write(array $input): ?Message;
}