<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

use Stringable;

/**
 * This class represents a single parameter.
 *
 * A parameter is an entity that holds a value that is
 * either set explicitly or derived from a default value.
 */
class Parameter implements Stringable
{
    /** The name of the parameter. */
    protected string $name;

    /** The default value of the parameter. */
    protected string $default;

    /** Whether the parameter is optional or not. */
    protected bool $optional;

    /** The explicitly set value of the parameter. */
    protected string $value;

    /**
     * The constructor for the Parameter class.
     *
     * @param string $name The name of the parameter.
     * @param bool $optional Whether the parameter is optional or not.
     * @param string $default The default value of the parameter.
     */
    public function __construct(string $name, string $default = '', bool $optional = false)
    {
        $this->name = $name;
        $this->default = $default;
        $this->optional = $optional;
    }

    /**
     * Checks whether the parameter has any valid value.
     *
     * @return bool Returns true if the parameter is valid, false otherwise.
     */
    public function isValid(): bool
    {
        return $this->optional || ($this->getValue() !== '');
    }

    /**
     * Returns the value of the parameter. If an explicit
     * value is not set, the default value is returned.
     *
     * @return string The value of the parameter.
     */
    public function getValue(): string
    {
        return $this->value ?? $this->default;
    }

    /**
     * Sets the explicit value of the parameter.
     *
     * @param string $value The explicit value of the parameter
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * Returns the name of the parameter.
     *
     * @return string The name of the parameter.
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function __toString(): string
    {
        return $this->getValue();
    }
}