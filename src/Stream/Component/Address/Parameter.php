<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

use Itsmattch\Nexus\Stream\Component\Address\Contract\ParameterInterface;
use Stringable;

/**
 * A parameter is an entity that holds a value that is
 * either set explicitly or derived from a default value.
 */
class Parameter implements ParameterInterface, Stringable
{
    /** The full name of the parameter matched with regex, including braces. */
    protected string $literal;

    /** The name of the parameter. */
    protected string $name;

    /** The default value of the parameter. */
    protected string $default;

    /** The explicitly set value of the parameter. */
    protected string $value;

    /**
     * The constructor for the Parameter class.
     *
     * @param string $name The name of the parameter.
     * @param string $default The default value of the parameter.
     */
    public function __construct(string $literal, string $name, string $default = '')
    {
        $this->literal = $literal;
        $this->name = $name;
        $this->default = $default;
    }

    public function isValid(): bool
    {
        return $this->getValue() !== '';
    }

    public function getValue(): string
    {
        return !empty($this->value) ? $this->value : $this->default;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getLiteral(): string
    {
        return $this->literal;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}