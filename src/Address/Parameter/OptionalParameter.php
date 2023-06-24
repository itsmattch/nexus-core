<?php

namespace Itsmattch\Nexus\Address\Parameter;

/** An optional parameter that is always considered valid. */
class OptionalParameter extends Parameter
{
    public function isValid(): bool
    {
        return true;
    }
}