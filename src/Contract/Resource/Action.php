<?php

namespace Itsmattch\NexusCore\Contract\Resource;

use Itsmattch\NexusCore\Contract\Resource;

/**
 * The Action interface represents an action that can be
 * performed on a Resource.
 */
interface Action
{
    /**
     * Performs the action on the given Resource.
     *
     * @param Resource $resource The resource on which the
     * action should be performed.
     */
    public function act(Resource $resource): void;
}