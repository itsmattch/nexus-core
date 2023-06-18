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
    /** todo */
    protected string $response = '';

    /** todo */
    protected Address $address;

    /** todo */
    protected string $message;

    /** todo */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /** todo */
    public function withMessage(string $message): void
    {
        $this->message = $message;
    }

    /** todo */
    protected abstract function boot(): bool;

    /** todo */
    protected abstract function execute(): bool;

    /** todo */
    protected abstract function close(): void;

    /** todo */
    public function access(): bool
    {
        if (!$this->boot()) {
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
    public function getResponse(): string
    {
        return $this->response;
    }
}