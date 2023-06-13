<?php

namespace Itsmattch\Nexus\Stream\Contract;

class Engine
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

    public function access(string $address): bool
    {
        return true;
    }

    public function getResponse(): Response
    {
        return $this->responseInstance;
    }
}