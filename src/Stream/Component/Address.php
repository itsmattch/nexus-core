<?php

namespace Itsmattch\Nexus\Stream\Component;

use Itsmattch\Nexus\Exceptions\Stream\Address\DynamicMethodMissingValueException;
use Itsmattch\Nexus\Exceptions\Stream\Address\UncaughtDynamicMethodException;
use Itsmattch\Nexus\Stream\Component\Address\Collection\ParametersCollection;
use Itsmattch\Nexus\Stream\Factory\ParametersCollectionFactory;
use Stringable;

/**
 * The Address class encapsulates an address to a resource,
 * providing a suite of methods for parametrizing it. It
 * uses a template-based approach, allowing for
 * mustache-styled parameters to define flexible addresses.
 *
 * @link https://nexus.itsmattch.com/resources/addresses Addresses Documentation
 */
abstract class Address implements Stringable
{
    /** Address template allowing for mustache-styled parameters. */
    protected string $template;

    /** Default values for parameters within the address template. */
    protected array $defaults = [];

    /** Generated collection of all parameter definitions. */
    private ParametersCollection $parametersCollection;

    /**
     * Constructs a new Address instance. It processes the
     * address template, extracts parameters, and
     * substitutes them with provided values.
     *
     * @param array $parameters An associative array of
     * parameters and their corresponding values
     */
    public function __construct(array $parameters = [])
    {
        $this->parametersCollection = ParametersCollectionFactory::from($this->template, $this->defaults, $this);

        foreach ($parameters as $name => $value) {
            $this->with($name, $value);
        }
    }

    /**
     * Sets the value of a specific parameter.
     *
     * @param string $parameterName The name of the parameter.
     * @param mixed $value The value to be set.
     * @return Address The current instance, allowing for method chaining.
     */
    public function with(string $parameterName, mixed $value): Address
    {
        $this->parametersCollection->get($parameterName)->setValue($value);
        return $this;
    }

    /**
     * Magic method for handling dynamic methods starting
     * with "with" or "is".
     *
     * @param string $method The name of the method.
     * @param array $arguments The arguments passed to the method.
     * @return Address The current instance, allowing for method chaining.
     * @throws UncaughtDynamicMethodException
     * @throws DynamicMethodMissingValueException
     */
    public function __call(string $method, array $arguments)
    {
        if (sizeof($arguments) < 1) {
            throw new DynamicMethodMissingValueException($method);
        }

        $prefixes = ['with' => 4, 'is' => 2];

        foreach ($prefixes as $prefix => $length) {
            if (str_starts_with($method, $prefix) && strlen($method) > $length) {
                $substring = substr($method, $length);
                $replacement = preg_replace('/(?<!^)[A-Z]/', '_$0', $substring);
                $parameter = strtolower($replacement);
                return $this->with($parameter, $arguments[0]);
            }
        }
        throw new UncaughtDynamicMethodException($method);
    }

    /**
     * Checks if all required parameters are set.
     *
     * @return bool True if the address is valid, false otherwise
     */
    public function isValid(): bool
    {
        return $this->parametersCollection->isValid();
    }

    /**
     * Checks if the address contains parameters with
     * the given names. This method accepts an arbitrary
     * number of arguments, each of which should be a string
     * representing a parameter name.
     *
     * @param string ...$names The names of the parameters to check for.
     * @return bool Returns true if all parameters are found, false otherwise.
     */
    public function has(string ...$names): bool
    {
        return $this->parametersCollection->has(... $names);
    }

    /**
     * Retrieves the raw address template.
     *
     * @return string The address template.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Retrieves the address in its current state,
     * irrespective of its validity.
     *
     * @return string The address in its current state.
     */
    public function getCurrentState(): string
    {
        $address = $this->template;
        foreach ($this->parametersCollection as $parameter) {
            if (!$parameter->isValid()) {
                continue;
            }
            $name = $parameter->getName();
            $address = preg_replace("/{@?$name}/", $parameter->getValue(), $address);
        }
        return $address;
    }

    /**
     * Returns value of a single parameter.
     *
     * @param string $name
     * @return string
     */
    public function getParameterValue(string $name): string
    {
        return $this->parametersCollection->get($name)->getValue();
    }

    /**
     * Returns a scheme name.
     *
     * @return string A scheme name.
     */
    public function getScheme(): string
    {
        return strstr($this->getAddress(), '://', true);
    }

    /**
     * Retrieves the final, valid address. If the address
     * is not valid, it returns an empty string.
     *
     * @return string The final address or an empty string.
     */
    public function getAddress(): string
    {
        if (!$this->isValid()) {
            return '';
        }

        return $this->getCurrentState();
    }

    public function __toString(): string
    {
        return $this->getAddress();
    }
}