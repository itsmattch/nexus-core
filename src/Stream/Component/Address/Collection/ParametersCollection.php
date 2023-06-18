<?php

namespace Itsmattch\Nexus\Stream\Component\Address\Collection;

use Countable;
use Iterator;
use Itsmattch\Nexus\Stream\Component\Address\Contract\ParameterInterface;
use Itsmattch\Nexus\Stream\Component\Address\NullParameter;

/**
 * This class is a collection of Parameter objects.
 */
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
     * @param ParameterInterface $parameter Parameter to be added.
     */
    public function set(ParameterInterface $parameter): void
    {
        $this->parameters[$parameter->getName()] = $parameter;
    }

    /**
     * Get parameter by its name. Returns singleton instance
     * of null parameter if the name is not found.
     * @param string $name
     * @return ParameterInterface
     */
    public function get(string $name): ParameterInterface
    {
        return $this->parameters[$name] ?? NullParameter::getInstance();
    }

    /**
     * Checks if the collection contains parameters with
     * the given names. This method accepts an arbitrary
     * number of arguments, each of which should be a string
     * representing a parameter name.
     *
     * @param string ...$names The names of the parameters to check for.
     * @return bool Returns true if all parameters are found, false otherwise.
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
     * @param string ...$names The names of the parameters to check for.
     * @return bool Returns true if all parameters are found, false otherwise.
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
     * @return ParameterInterface The current parameter.
     */
    public final function current(): ParameterInterface
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