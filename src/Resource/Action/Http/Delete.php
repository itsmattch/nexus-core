<?php

namespace Itsmattch\NexusCore\Resource\Action\Http;

use Itsmattch\NexusCore\Contract\Resource;
use Itsmattch\NexusCore\Contract\Resource\Action;
use Itsmattch\NexusCore\Engine\Enum\HttpMethod;

class Delete implements Action
{
    public function act(Resource $resource): void
    {
        $resource->getEngine()->setMethod(HttpMethod::DELETE);
    }
}