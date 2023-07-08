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
     * Retrieves the message received from the execution of
     * the connection. This method must be called after
     * execute() has been called.
     *
     * @return ?Message An instance of the Message class
     * representing the response received from the execution
     * of the connection.
     */
    public function execute(): ?Message;

    /**
     * Closes the connection after the execution.
     */
    public function close(): void;

    /**
     * Attaches a message to be sent when the execute method
     * is called. This method must be called prior to
     * execute().
     *
     * @param Message $message An instance of the Message
     * class representing the payload to be sent with the
     * execution.
     */
    public function attach(Message $message): void;
}