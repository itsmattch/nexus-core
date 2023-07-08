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
     * Attempts to access and read the resource.
     */
    public function performOnce(): void;

    /**
     * todo return Resource instead?
     *
     * @return array Returns the content of the resource as
     * an array, with the content structure depending on the
     * resource type.
     */
    public function getContent(): array;
}