<?php

namespace Itsmattch\NexusCore\Contract;

use Itsmattch\NexusCore\Common\Message;

/**
 * Reader interface specifies methods for interpreting
 * a Message into data.
 */
interface Reader
{
    /**
     * Reads the given message and converts it into an array.
     *
     * @param Message $message The message to be read.
     * @return array The interpreted data from the message.
     */
    public function read(Message $message): array;
}