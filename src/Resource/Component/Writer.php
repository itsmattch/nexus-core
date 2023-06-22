<?php

namespace Itsmattch\Nexus\Resource\Component;

use Itsmattch\Nexus\Resource\Component\Engine\Request;

/** todo the opposite of reader. */
abstract class Writer
{
    protected array $body;

    public final function __construct(array $body)
    {
        $this->body = $body;
    }

    public abstract function write(): bool;
    public abstract function get(): Request;

}