<?php

namespace Itsmattch\Nexus\Contract\Assembler;

use Itsmattch\Nexus\Contract\Assembler;
use Itsmattch\Nexus\Contract\Model\Collection;

/** todo */
interface Repository extends Assembler
{
    /** todo */
    public function setCollection(Collection $collection): void;

    /** todo */
    public function getCollection(): Collection;
}