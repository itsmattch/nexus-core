<?php

namespace Itsmattch\Nexus\Resource\Component;

use Itsmattch\Nexus\Resource\Component\Engine\Response;

/**
 * The Engine class encapsulates the logic responsible for
 * handling the connection and reading of a resource.
 *
 * @link https://nexus.itsmattch.com/resources/engines Engines Documentation
 */
abstract class Engine
{
    /**
     * Represents the Response class that should be used
     * for handling the response from accessing the resource.
     */
    protected string $response = Response::class;

    /**
     * Stores the instance of the Response class that is
     * created during booting.
     */
    private Response $responseInstance;

    /**
     * Represents the location of the resource that the
     * Engine should access.
     */
    private Address $address;

    public final function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * A method for preparing to access the resource.
     * This could involve setting up a connection,
     * authenticating, or other setup tasks.
     *
     * The specific implementation depends on the subclass.
     *
     * @return bool True on successful preparation, false otherwise.
     */
    protected abstract function prepare(): bool;

    /**
     * A method for executing the access to the resource.
     * This could involve sending a request, receiving a
     * response, or other execution tasks.
     *
     * The specific implementation depends on the subclass.
     *
     * @return bool True on successful execution, false otherwise.
     */
    protected abstract function execute(): bool;

    /**
     * A method for cleaning up after the execution of
     * resource access. This could involve closing a
     * connection, deallocating resources, or other
     * cleanup tasks.
     *
     * The specific implementation depends on the subclass.
     */
    protected abstract function close(): void;

    /** Boots the engine. */
    public final function boot(): bool
    {
        if (!$this->internallyBootResponse()) {
            return false;
        }
        if (!$this->prepare()) {
            return false;
        }
        return true;
    }

    /**
     * A method for executing the entire process of
     * accessing a resource.
     *
     * @return bool True on successful access, false otherwise.
     */
    public function access(): bool
    {
        if (!$this->execute()) {
            $this->close();
            return false;
        }
        $this->close();
        return true;
    }

    /**
     * A method for internally booting the Response
     * instance. It creates a new instance of the Response
     * subclass specified in the $response property.
     */
    private function internallyBootResponse(): bool
    {
        $this->responseInstance = new $this->response;
        return $this->bootResponse($this->responseInstance);
    }

    /**
     * This method allows you to modify created Response instance.
     *
     * @param Response $response Created Response instance.
     * @return bool The result of booting.
     */
    protected function bootResponse(Response $response): bool { return true; }

    public function getResponse(): Response
    {
        return $this->responseInstance;
    }

    protected final function address(): string
    {
        return (string)$this->address;
    }
}