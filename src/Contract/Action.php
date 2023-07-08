<?php

namespace Itsmattch\Nexus\Contract;

/**
 * Action represents a singular action performable on a
 * resource, like reading or writing.
 *
 * @link https://nexus.itsmattch.com/the-basics/action Actions Documentation
 */
interface Action
{
    /**
     * Performs a specific action on the resource
     */
    public function performOnce(): void;

    /**
     * Retrieves the content resulting from the action
     * performed on the resource
     *
     * @return array The content of the resource.
     */
    public function getContent(): array;
}