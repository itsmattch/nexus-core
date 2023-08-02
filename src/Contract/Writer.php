<?php

namespace Itsmattch\NexusCore\Contract;

use Itsmattch\NexusCore\Common\Message;

/**
 * Writer interface specifies methods for
 * transforming data into a Message.
 */
interface Writer
{
    /**
     * Transforms input data into a Message.
     *
     * @param array $input The data to be transformed.
     *
     * @return ?Message The resulting Message or null if
     * unsuccessful.
     */
    public function write(array $input): ?Message;
}