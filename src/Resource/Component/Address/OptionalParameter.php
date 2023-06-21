<?php

namespace Itsmattch\Nexus\Resource\Component\Address;

/** An optional parameter that is always considered valid. */
class OptionalParameter extends Parameter
{
    public function isValid(): bool
    {
        return true;
    }
}