<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

/**
 * This class represents an optional parameter.
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