<?php

namespace Itsmattch\Nexus\Reader;

use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Reader as ReaderContract;

/**
 * The Reader class is responsible for reading raw content
 * of the resources and turning it into PHP arrays.
 *
 * @link https://nexus.itsmattch.com/resources/readers Readers Documentation
 */
abstract class Reader implements ReaderContract
{
    /** Instance of the Response class containing received raw content. */
    protected Message $response;

    final public function __construct(Message $response)
    {
        $this->response = $response;
    }
}