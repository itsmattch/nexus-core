<?php

namespace Itsmattch\Nexus\Stream\Component;

/**
 * The Engine class encapsulates the logic responsible for
 * handling the connection and reading of a resource.
 *
 * @link https://nexus.itsmattch.com/streams/engines Engines Documentation
 */
abstract class Engine
{
    protected string $response = Response::class;

    private Response $responseInstance;

    public function boot(): bool
    {
        if (!$this->internallyBootResponse()) {
            return false;
        }
        return true;
    }

    protected function internallyBootResponse(): bool
    {
        $this->responseInstance = new $this->response;
        return $this->bootResponse($this->responseInstance);
    }

    protected function bootResponse(Response $response): bool { return true; }

    // todo

    public function getResponse(): Response
    {
        return $this->responseInstance;
    }
}