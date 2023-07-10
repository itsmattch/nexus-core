<?php

namespace Itsmattch\Nexus\Resource\Action\Http;

use Itsmattch\Nexus\Contract\Resource;
use Itsmattch\Nexus\Contract\Resource\Action;
use Itsmattch\Nexus\Engine\Enum\HttpMethod;

class Delete implements Action
{
    public function act(Resource $resource): void
    {
        $resource->getEngine()->setMethod(HttpMethod::DELETE);
    }
}