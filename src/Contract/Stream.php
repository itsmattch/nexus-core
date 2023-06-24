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
     * Accesses the resource.
     *
     * @return bool True on success, false otherwise.
     */
    public function access(): bool;

    /**
     * Converts the content of the resource into an array.
     *
     * @return bool True on success, false otherwise.
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