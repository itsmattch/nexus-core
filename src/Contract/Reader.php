<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Reader class is responsible for reading raw content
 * of the resources and turning it into PHP arrays.
 *
 * @link https://nexus.itsmattch.com/digging-deeper/reader Readers Documentation
 */
interface Reader
{
    /**
     * @param string $raw The raw content to be processed.
     */
    public function setInput(string $raw): void;

    /**
     * Processes the raw input content and attempts to
     * convert it into a PHP array.
     *
     * @return bool Returns true if the content was
     * successfully read and converted, false otherwise.
     */
    public function read(): bool;

    /**
     * Retrieves the PHP array produced by the read
     * operation. This is the array representation of the
     * previously raw content.
     *
     * @return array The array representation of the
     * content.
     */
    public function get(): array;
}