<?php

namespace Itsmattch\Nexus\Stream\Component;

use Itsmattch\Nexus\Exceptions\Stream\Address\DynamicMethodMissingValueException;
use Itsmattch\Nexus\Exceptions\Stream\Address\MissingParameterException;
use Itsmattch\Nexus\Exceptions\Stream\Address\UncaughtDynamicMethodException;
use Itsmattch\Nexus\Stream\Component\Address\Collection\ParametersCollection;
use Itsmattch\Nexus\Stream\Component\Address\NullParameter;
use Itsmattch\Nexus\Stream\Factory\ParametersCollectionFactory;
use Stringable;

/**
 * The Address class encapsulates an address to a resource,
 * providing a suite of methods for parametrizing it. It
 * uses a template-based approach, allowing for
 * mustache-styled parameters to define flexible addresses.
 *
 * @link https://nexus.itsmattch.com/streams/addresses Addresses Documentation
 */
abstract class Address implements Stringable
{
    /** Address template allowing for mustache-styled parameters. */
    protected string $template = '';

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
     * @throws MissingParameterException
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
     * @throws MissingParameterException
     */
    public function with(string $parameterName, mixed $value): Address
    {
        if ($this->parametersCollection->get($parameterName) instanceof NullParameter) {
            throw new MissingParameterException($parameterName);
        }
        $this->parametersCollection->get($parameterName)->setValue($value);

        return $this;
    }

    /**
     * Magic method for handling dynamic methods starting
     * with "with" or "is".
     *
     * @param string $name The name of the method.
     * @param array $arguments The arguments passed to the method.
     * @return Address The current instance, allowing for method chaining.
     * @throws UncaughtDynamicMethodException
     * @throws DynamicMethodMissingValueException
     * @throws MissingParameterException
     */
    public function __call(string $name, array $arguments)
    {
        if (sizeof($arguments) < 1) {
            throw new DynamicMethodMissingValueException();
        }

        $prefixes = ['with' => 4, 'is' => 2];

        foreach ($prefixes as $prefix => $length) {
            if (str_starts_with($name, $prefix) && strlen($name) > $length) {
                $substring = substr($name, $length);
                $replacement = preg_replace('/(?<!^)[A-Z]/', '_$0', $substring);
                $parameter = strtolower($replacement);
                return $this->with($parameter, $arguments[0]);
            }
        }
        throw new UncaughtDynamicMethodException($name);
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