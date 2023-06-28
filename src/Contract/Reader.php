<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Reader class is responsible for reading raw content
 * of the resources and turning it into PHP arrays.
 *
 * @link https://nexus.itsmattch.com/resources/readers Readers Documentation
 */
interface Reader
{
    /**
     * Turns the raw content into a PHP array.
     * Implementations of this method should parse the
     * response and set any necessary internal state to
     * reflect the parsed content.
     *
     * @return bool True if successfully read,
     * false otherwise.
     */
    public function read(): bool;

    /**
     * Returns the PHP array produced by read().
     *
     * Implementations of this method should return the PHP
     * array representation of the content read by read().
     *
     * @return array The PHP array representation of the
     * content.
     */
    public function get(): array;
}