<?php

namespace Itsmattch\Nexus\Common\Traits;

use Exception;

/**
 * Implements a boot-once logic for classes. This trait
 * ensures that the boot process is performed only once and
 * keeps track of its success.
 */
trait BootsOnce
{
    /** Flag indicating if the boot process was successful. */
    private bool $bootedSuccessfully = false;

    /**
     * Perform the boot process only once.
     *
     * This method attempts to boot the system only if it
     * has not been booted successfully before.
     *
     * @return bool True if the boot process was successful,
     * false otherwise.
     */
    public function boot(): bool
    {
        try {
            if (!$this->isBooted()) {
                $this->bootedSuccessfully = $this->safeBoot();
            }
        } catch (Exception) {
        } finally {
            return $this->bootedSuccessfully;
        }
    }

    /**
     * @return bool True if the system booted successfully,
     * false otherwise.
     */
    public function isBooted(): bool
    {
        return $this->bootedSuccessfully;
    }

    /**
     * Perform the boot process.
     *
     * This method should contain the actual boot logic for
     * the class that uses this trait.
     *
     * @return bool True if the boot process was successful,
     * false otherwise.
     */
    abstract protected function safeBoot(): bool;
}