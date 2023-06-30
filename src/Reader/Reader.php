<?php

namespace Itsmattch\Nexus\Reader;

use Itsmattch\Nexus\Contract\Reader as ReaderContract;

abstract class Reader implements ReaderContract
{
    protected readonly string $raw;

    public function setInput(string $raw): void
    {
        $this->raw = $raw;
    }
}