<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

use Iterator;

/**
 * This class is a collection of Parameter objects.
 */
class ParametersCollection implements Iterator
{

    /** The original string */
    protected string $string;

    /** A collection of parameters */
    protected array $parameters = [];

    /** The current position within the array of keys. */
    protected int $position = 0;

    /**
     * Add or update a parameter to the collection.
     * Parameters are recognized by their name, and it must
     * be unique within collection.
     * @param Parameter $parameter Parameter to be added.
     */
    public function set(Parameter $parameter): void
    {
        $this->parameters[$parameter->getName()] = $parameter;
    }

    /**
     * Get parameter by its name. Returns singleton instance
     * of null parameter if the name is not found.
     * @param string $name
     * @return Parameter
     */
    public function get(string $name): Parameter
    {
        return $this->parameters[$name] ?? NullParameter::getInstance();
    }


    /**
     * Checks if all the parameters in the collection are valid.
     * @return bool Returns true if all parameters are valid, false otherwise.
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

    /**
     * Returns the current parameter in the iteration.
     * @return Parameter The current parameter.
     */
    public final function current(): Parameter
    {
        return $this->parameters[array_keys($this->parameters)[$this->position]];
    }

    /**
     * Returns the key of the current parameter in the iteration.
     * @return string The key of the current parameter.
     */
    public final function key(): string
    {
        return array_keys($this->parameters)[$this->position];
    }

    /**
     * Advances the iterator to the next parameter.
     */
    public final function next(): void
    {
        ++$this->position;
    }

    /**
     * Checks if there is a current element after calls to rewind() or next().
     * @return bool Returns true if there is a current element, false otherwise.
     */
    public final function valid(): bool
    {
        return isset(array_keys($this->parameters)[$this->position]);
    }

    /**
     * Rewinds the Iterator to the first element.
     */
    public final function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Returns the count of parameters in the collection.
     * @return int The count of parameters.
     */
    public final function count(): int
    {
        return sizeof($this->parameters);
    }
}