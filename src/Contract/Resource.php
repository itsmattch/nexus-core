<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Resource\Action;

/**
 * A Resource represents an external entity that can be
 * interacted with different Actions.
 */
interface Resource
{
    public function getAddress(): Address;

    public function getEngine(): Engine;

    public function getReader(): Reader;

    public function getWriter(): Writer;

    /**
     * Perform an Action on the Resource.
     *
     * @param Action $action The action to be performed on
     * the resource.
     *
     * @return array The data received from the resource as
     * a result of the action.
     */
    public function trigger(Action $action): array;
}