<?php

namespace Itsmattch\Nexus\Contract\Assembler;

use Itsmattch\Nexus\Contract\Assembler;
use Itsmattch\Nexus\Contract\Model;

/** todo */
interface Blueprint extends Assembler
{
    /** todo */
    public function getModel(): Model;
}