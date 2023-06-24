<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Engine class encapsulates the logic responsible for
 * handling the connection and reading of a resource.
 *
 * @link https://nexus.itsmattch.com/resources/engines Engines Documentation
 */
interface Engine
{
    /**
     * A method for preparing to access the resource.
     * This could involve setting up a connection,
     * authenticating, or other setup tasks.
     *
     * The specific implementation depends on the subclass.
     *
     * @return bool True on successful preparation, false otherwise.
     */
    public function init(): bool;

    /**
     * A method for executing the access to the resource.
     * This could involve sending a request, receiving a
     * response, or other execution tasks.
     *
     * The specific implementation depends on the subclass.
     *
     * @return bool True on successful execution, false otherwise.
     */
    public function execute(): bool;

    /**
     * A method for cleaning up after the execution of
     * resource access. This could involve closing a
     * connection, deallocating resources, or other
     * cleanup tasks.
     *
     * The specific implementation depends on the subclass.
     */
    public function close(): void;
}