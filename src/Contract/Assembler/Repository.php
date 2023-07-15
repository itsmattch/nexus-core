<?php

namespace Itsmattch\Nexus\Contract\Assembler;

use Itsmattch\Nexus\Contract\Assembler;
use Itsmattch\Nexus\Contract\Entity\Collection;

/** todo */
interface Repository extends Assembler
{
    /** todo */
    public function getCollection(): Collection;
}