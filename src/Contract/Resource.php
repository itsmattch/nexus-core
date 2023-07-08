<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Resource\Action;

/**
 * todo
 */
interface Resource
{
    public function trigger(Action $action): void;
}