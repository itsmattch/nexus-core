<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

/**
 * An optional parameter that is always considered valid.
 */
class OptionalParameter extends Parameter
{
    /**
     * Optional parameters are always considered valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }
}