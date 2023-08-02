<?php

namespace Itsmattch\NexusCore\Contract\Assembler;

use Itsmattch\NexusCore\Contract\Assembler;
use Itsmattch\NexusCore\Contract\Entity;

/** todo */
interface Blueprint extends Assembler
{
    /** todo */
    public function getEntity(): Entity;
}