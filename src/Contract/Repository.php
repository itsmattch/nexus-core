<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Common\Bootable;
use Itsmattch\Nexus\Model\Collection;

interface Repository extends Bootable
{
    /**
     * Accesses all resources.
     *
     * @return bool True on success, false otherwise.
     */
    public function access(): bool;

    /**
     * Converts the content of the resources into a
     * collection of model identities.
     *
     * @return bool True on success, false otherwise.
     */
    public function read(): bool;

    /**
     * Returns collection of model identities.
     *
     * @return Collection Collection of model identities.
     */
    public function getCollection(): Collection;
}