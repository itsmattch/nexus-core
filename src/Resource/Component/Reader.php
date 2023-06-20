<?php

namespace Itsmattch\Nexus\Resource\Component;

use Itsmattch\Nexus\Resource\Component\Engine\Response;

/**
 *
 * @link https://nexus.itsmattch.com/resources/readers Readers Documentation
 */
abstract class Reader
{
    /** todo */
    protected Response $response;

    /** todo */
    public final function __construct(Response $response)
    {
        $this->response = $response;
    }

    /** todo */
    public abstract function read(): bool;

    public abstract function get(): array;
}