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
     * Prepares a connection handler.
     *
     * @return bool True on success, false otherwise.
     */
    public function init(): bool;

    /**
     * Executes the connection and reads the response.
     *
     * @return bool True on success, false otherwise.
     */
    public function execute(): bool;

    /** Closes the connection after the execution. */
    public function close(): void;

    /** todo */
    public function setRequest(Message $message): void;

    /** Returns the response as Message instance. */
    public function getResponse(): Message;
}