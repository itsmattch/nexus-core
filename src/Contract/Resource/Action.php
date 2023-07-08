<?php

namespace Itsmattch\Nexus\Contract\Resource;

use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Writer;

/** todo */
interface Action
{
    /** todo */
    public function act(Engine $engine, Writer $writer): void;
}