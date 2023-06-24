<?php

namespace Itsmattch\Nexus\Address\Parameter\Collection;

use Countable;
use Iterator;
use Itsmattch\Nexus\Address\Contract\Parameter as ParameterContract;
use Itsmattch\Nexus\Address\Parameter\NullParameter;

/** A collection of Parameter objects. */
class ParametersCollection implements Iterator, Countable
{
    /** A collection of parameters */
    protected array $parameters = [];

    /** The current position within the array of keys. */
    protected int $position = 0;

    /**
     * Add or update a parameter to the collection.
     * Parameters are recognized by their name, and it must
     * be unique within collection.
     *
     * @param ParameterContract $parameter Parameter to add.
     */
    public function set(ParameterContract $parameter): void
    {
        $this->parameters[$parameter->getName()] = $parameter;
    }

    /**
     * Get parameter by its name. Returns singleton instance
     * of null parameter if the name is not found.
     *
     * @param string $name Parameter name.
     *
     * @return ParameterContract Found parameter, or null.
     */
    public function get(string $name): ParameterContract
    {
        return $this->parameters[$name] ?? NullParameter::getInstance();
    }

    /**
     * Checks if the collection contains parameters with
     * the given names. This method accepts an arbitrary
     * number of arguments, each of which should be a string
     * representing a parameter name.
     *
     * @param string ...$names The names of the parameters
     * to check for.
     *
     * @return bool Returns true if all parameters are
     * found, false otherwise.
     */
    public function has(string ...$names): bool
    {
        foreach ($names as $name) {
            if (!array_key_exists($name, $this->parameters)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the collection contains parameters with
     * the given names and validates them. This method
     * accepts an arbitrary number of arguments, each of
     * which should be a string representing a parameter
     * name.
     *
     * @param string ...$names The names of the parameters
     * to check for.
     *
     * @return bool Returns true if all parameters are
     * found, false otherwise.
     */
    public function hasValid(string ...$names): bool
    {
        foreach ($names as $name) {
            if (!array_key_exists($name, $this->parameters) || !$this->parameters[$name]->isValid()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if all parameters in the collection are valid.
     *
     * @return bool Returns true if all parameters are
     * valid, false otherwise.
     */
    public function isValid(): bool
    {
        foreach ($this->parameters as $parameter) {
            if (!$parameter->isValid()) {
                return false;
            }
        }
        return true;
    }

    public final function current(): ParameterContract
    {
        return $this->parameters[array_keys($this->parameters)[$this->position]];
    }

    public final function key(): string
    {
        return array_keys($this->parameters)[$this->position];
    }

    public final function next(): void
    {
        ++$this->position;
    }

    public final function valid(): bool
    {
        return isset(array_keys($this->parameters)[$this->position]);
    }

    public final function rewind(): void
    {
        $this->position = 0;
    }

    public final function count(): int
    {
        return sizeof($this->parameters);
    }
}