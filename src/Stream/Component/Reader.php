<?php

namespace Itsmattch\Nexus\Stream\Component;

use Itsmattch\Nexus\Stream\Component\Engine\Message;

/**
 * The Reader class is responsible for reading raw content
 * of the resources and turning it into PHP arrays.
 *
 * @link https://nexus.itsmattch.com/resources/readers Readers Documentation
 */
abstract class Reader
{
    /** Instance of the Response class containing received raw content. */
    protected Message $response;

    public final function __construct(Message $response)
    {
        $this->response = $response;
    }

    /**
     * Turns the raw content into a PHP array.
     * Implementations of this method should parse the
     * response and set any necessary internal state to
     * reflect the parsed content.
     *
     * @return bool True if successfully read, false otherwise.
     */
    public abstract function read(): bool;

    /**
     * Returns the PHP array produced by read().
     *
     * Implementations of this method should return the PHP
     * array representation of the content read by read().
     *
     * @return array The PHP array representation of the content/
     */
    public abstract function get(): array;
}