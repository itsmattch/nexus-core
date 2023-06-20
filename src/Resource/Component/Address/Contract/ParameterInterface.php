<?php

namespace Itsmattch\Nexus\Resource\Component\Address\Contract;

/**
 * Represents a parameter in an address template
 * that can be replaced with a value.
 */
interface ParameterInterface
{
    /**
     * Returns the full name of the parameter matched with
     * regex, including braces.
     *
     * @return string The name of the parameter.
     */
    public function getLiteral(): string;

    /**
     * Returns the name of the parameter.
     *
     * @return string The name of the parameter.
     */
    public function getName(): string;

    /**
     * Returns the value of the parameter. If an explicit
     * value is not set, the default value is returned.
     *
     * @return string The value of the parameter.
     */
    public function getValue(): string;

    /**
     * Sets the explicit value of the parameter.
     *
     * @param mixed $value The explicit value of the parameter
     * @return void
     */
    public function setValue(mixed $value): void;

    /**
     * Checks whether the parameter has any valid value.
     *
     * @return bool Returns true if the parameter is valid, false otherwise.
     */
    public function isValid(): bool;
}