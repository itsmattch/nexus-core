<?php

namespace Itsmattch\Nexus\Contract\Common;

/**
 * Represents an object whose state can be validated.
 * Implementations should throw an exception if the object
 * is in an invalid state.
 */
interface Validatable
{
    /**
     * Validates the inner state of this object.
     *
     * This method should check the internal state of this
     * object and throw an exception if the state is
     * invalid. The exact nature of what is considered
     * "valid" is up to the implementation.
     */
    public function validate(): void;
}