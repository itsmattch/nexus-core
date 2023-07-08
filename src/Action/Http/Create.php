<?php

namespace Itsmattch\Nexus\Action\Http;

use Itsmattch\Nexus\Contract\Resource;
use Itsmattch\Nexus\Contract\Resource\Action;
use Itsmattch\Nexus\Engine\Enum\HttpMethod;

abstract class Create implements Action
{
    public function act(Resource $resource): void
    {
        $resource->getEngine()->setMethod(HttpMethod::POST);
    }
}