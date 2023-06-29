<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Common\Message;

/**
 * Engines encapsulate the logic for connecting to and
 * reading from a resource.
 *
 * @link https://nexus.itsmattch.com/digging-deeper/engine Engines Documentation
 */
interface Engine
{
    /**
     * @param Address $address An instance of Address
     * representing the resource's location.
     */
    public function setAddress(Address $address): void;

    /**
     * Prepares a connection handler.
     *
     * @return bool Returns true if the connection handler
     * was successfully initialized, false otherwise.
     */
    public function initialize(): bool;

    /**
     * Executes the connection and reads the response.
     *
     * @return bool Returns true if the connection was
     * successful and the response was successfully read,
     * false otherwise.
     */
    public function execute(): bool;

    /**
     * Closes the connection after the execution.
     */
    public function close(): void;

    /**
     * Sets the request body.
     *
     * @param Message $message A Message instance
     * representing the request body.
     */
    public function setRequest(Message $message): void;

    /**
     * Retrieves the response as Message instance.
     *
     * @return Message A Message instance representing the
     * resource's response.
     */
    public function getResponse(): Message;
}