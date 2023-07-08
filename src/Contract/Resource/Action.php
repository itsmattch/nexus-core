<?php

namespace Itsmattch\Nexus\Contract\Resource;

use Itsmattch\Nexus\Contract\Resource;

/** todo */
interface Action
{
    /** todo */
    public function act(Resource $resource): void;
}