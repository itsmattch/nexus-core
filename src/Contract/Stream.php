<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Stream class represents a single access point of data
 * within the Nexus system. It acts as an encapsulation of
 * all information necessary to access, read and interpret
 * a resource.
 *
 * @link https://nexus.itsmattch.com/streams/overview Streams Documentation
 */
interface Stream
{
    /**
     * Accesses the raw resource. This could mea
     * establishing a connection, opening a file, or some
     * other form of accessing the raw data.
     *
     * @return bool True if the raw resource was
     * successfully accessed, false otherwise.
     */
    public function access(): bool;

    /**
     * Converts the raw content into a PHP array. This could
     * involve parsing a file, decoding a data stream, or
     * otherwise interpreting the raw data.
     *
     * @return bool True if the content was successfully
     * read and converted, false otherwise.
     */
    public function read(): bool;

    /**
     * Returns the name of the group that the stream belongs
     * to. Groups are used to cluster together different
     * streams that utilize the same set of identifiers.
     *
     * @return string The name of the group the stream
     * belongs to.
     */
    public function getGroupName(): string;
}