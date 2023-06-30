<?php

namespace Itsmattch\Nexus\Writer;

use Itsmattch\Nexus\Common\Message;

/** todo the opposite of reader. */
abstract class Writer
{
    protected array $body;

    final public function __construct(array $body)
    {
        $this->body = $body;
    }

    public abstract function write(): bool;

    public abstract function get(): Message;

}