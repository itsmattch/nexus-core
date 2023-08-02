<?php

namespace Itsmattch\NexusCore\Contract\Address;

/**
 * Represents a parameter in an address template
 * that can be replaced with a value.
 */
interface Parameter
{
    /**
     * @return string The full representation of the
     * parameter, including braces.
     */
    public function getLiteral(): string;

    /**
     * @return string The name of the parameter.
     */
    public function getName(): string;

    /**
     * @return string The value of the parameter.
     */
    public function getValue(): string;

    /**
     * @param mixed $value The value of the parameter.
     */
    public function setValue(mixed $value): void;

    /**
     * @return bool Returns true if the parameter has a
     * valid value, false otherwise.
     */
    public function isValid(): bool;
}