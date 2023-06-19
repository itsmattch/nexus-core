<?php

namespace Itsmattch\Nexus\Stream\Component;

use Itsmattch\Nexus\Stream\Component\Engine\Response;

/** todo */
abstract class Reader
{
    /** todo */
    protected Response $response;

    /** todo */
    protected Resource $resource;

    /** todo */
    public function __construct(Response $response, Resource $resource)
    {
        $this->response = $response;
        $this->resource = $resource;
    }

    /** todo */
    public abstract function read(): bool;

    /** todo */
    public function getResource(): Resource
    {
        return $this->resource;
    }
}