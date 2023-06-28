<?php

namespace Itsmattch\Nexus\Reader;

use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Reader as ReaderContract;

abstract class Reader implements ReaderContract
{
    protected readonly Message $message;

    final public function __construct(Message $message)
    {
        $this->message = $message;
    }
}