<?php

namespace Itsmattch\Nexus\Contract\Assembler;

use Itsmattch\Nexus\Contract\Assembler;
use Itsmattch\Nexus\Contract\Entity;

/** todo */
interface Blueprint extends Assembler
{
    /** todo */
    public function getEntity(): Entity;
}