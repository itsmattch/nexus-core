<?php

namespace Itsmattch\Nexus\Engine\Concrete\Action;

use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Resource\Action;
use Itsmattch\Nexus\Contract\Writer;
use Itsmattch\Nexus\Engine\Concrete\HttpEngine;

class Read implements Action
{
    /**
     * @param HttpEngine $engine
     * @param Writer $writer
     */
    public function act(Engine $engine, Writer $writer): void
    {
        //
    }
}