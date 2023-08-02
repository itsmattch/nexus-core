<?php

namespace Itsmattch\NexusCore\Contract\Assembler;

use Itsmattch\NexusCore\Contract\Assembler;
use Itsmattch\NexusCore\Contract\Entity\Collection;

/** todo */
interface Repository extends Assembler
{
    /** todo */
    public function getCollection(): Collection;
}