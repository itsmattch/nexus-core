<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Common\Message;

/**
 * The Engine class encapsulates the logic responsible for
 * handling the connection and reading of a resource.
 *
 * @link https://nexus.itsmattch.com/resources/engines Engines Documentation
 */
interface Engine
{
    /**
     * Sets the address to a resource.
     */
    public function setAddress(Address $address): void;

    /**
     * Prepares a connection handler.
     *
     * @return bool True on success, false otherwise.
     */
    public function initialize(): bool;

    /**
     * Executes the connection and reads the response.
     *
     * @return bool True on success, false otherwise.
     */
    public function execute(): bool;

    /**
     * Closes the connection after the execution.
     */
    public function close(): void;

    /**
     * Sets the request body.
     */
    public function setRequest(Message $message): void;

    /**
     * Returns the response as Message instance.
     */
    public function getResponse(): Message;
}