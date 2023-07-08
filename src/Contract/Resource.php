<?php

namespace Itsmattch\Nexus\Contract;

/**
 * todo
 */
interface Resource
{
    /**
     * Performs a specific action on the resource
     */
    public function performOnce(): void;

    public function trigger();
}