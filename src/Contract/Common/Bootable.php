<?php

namespace Itsmattch\Nexus\Contract\Common;

/**
 * Represents an object that can be booted up.
 * Implementations should return false if the booting
 * process is not successful, catching any exceptions that
 * are thrown and ensuring the object is left in a state
 * where it cannot be improperly used.
 */
interface Bootable
{
    /**
     * Boots up this object.
     *
     * This method should attempt to get this object up and
     * running. If it is impossible, it should return false.
     *
     * This operation should be fail-safe, meaning it should
     * not throw an exception.
     *
     * @return bool True if the object was successfully
     * booted up, false otherwise.
     */
    public function boot(): bool;

    /**
     * Returns the booting status. Objects that are not
     * booted might be faulty and should not be used.
     *
     * @return bool True if the object is successfully
     * booted, false otherwise.
     */
    public function isBooted(): bool;
}