<?php

namespace Itsmattch\Nexus\Stream\Component;

use Itsmattch\Nexus\Stream\Component\Engine\Response;

/**
 * The Engine class encapsulates the logic responsible for
 * handling the connection and reading of a resource.
 *
 * @link https://nexus.itsmattch.com/streams/engines Engines Documentation
 */
abstract class Engine
{
    /** todo */
    protected string $response = Response::class;

    /** todo */
    private Address $address;

    /** todo */
    protected Response $responseInstance;

    /** todo */
    public final function __construct(Address $address)
    {
        $this->address = $address;
    }

    /** todo */
    protected abstract function prepare(): bool;

    /** todo */
    protected abstract function execute(): bool;

    /** todo */
    protected abstract function close(): void;

    public final function boot(): bool
    {
        if (!$this->internallyBootResponse()) {
            return false;
        }
        return true;
    }

    protected final function internallyBootResponse(): bool {
        $this->responseInstance = new $this->response;
        return $this->bootResponse($this->responseInstance);
    }

    protected function bootResponse(Response $response): bool { return true; }

    /** todo */
    public function access(): bool
    {
        if (!$this->prepare()) {
            return false;
        }
        if (!$this->execute()) {
            $this->close();
            return false;
        }
        $this->close();
        return true;
    }

    /** todo */
    public function getResponse(): Response
    {
        return $this->responseInstance;
    }

    /** todo */
    protected final function address(): string {
        return (string) $this->address;
    }
}