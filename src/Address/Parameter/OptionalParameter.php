<?php

namespace Itsmattch\NexusCore\Address\Parameter;

/**
 * An optional parameter that is always considered valid.
 */
class OptionalParameter extends RequiredParameter
{
    public function isValid(): bool
    {
        return true;
    }
}