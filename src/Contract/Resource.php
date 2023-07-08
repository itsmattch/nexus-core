<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Resource\Action;

/**
 * todo
 */
interface Resource
{
    public function getAddress(): Address;

    public function getEngine(): Engine;

    public function getReader(): Reader;

    public function getWriter(): Writer;

    public function trigger(Action $action);
}