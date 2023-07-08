<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Common\Message;

/** todo */
interface Reader
{
    /** todo */
    public function read(Message $message): array;
}