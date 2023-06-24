<?php

namespace Itsmattch\Nexus\Address;

use Itsmattch\Nexus\Address\Contract\Parameter as ParameterContract;
use Itsmattch\Nexus\Address\Exception\InvalidSchemeException;
use Itsmattch\Nexus\Address\Parameter\NullParameter;
use Itsmattch\Nexus\Address\Parameter\OptionalParameter;
use Itsmattch\Nexus\Address\Parameter\ParameterProxy;
use Itsmattch\Nexus\Address\Parameter\RequiredParameter;
use Itsmattch\Nexus\Contract\Address as AddressContract;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Stringable;

abstract class Address implements AddressContract, Stringable, Validatable
{
    /** Address template allowing parameters. */
    protected string $template = '';

    /** Default values for parameters within the template. */
    protected array $defaults = [];

    /** Collection of all parameter definitions. */
    private array $parameters;

    protected static string $parametersTemplate = '/(?<literal>{(?<optional>@)?(?<name>[a-z0-9_]+)})/';

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
        preg_match_all(self::$parametersTemplate, $this->template, $parameters, PREG_SET_ORDER);

        foreach ($parameters as $parameter) {
            $name = $parameter['name'];
            $literal = $parameter['literal'];
            $default = $this->defaults[$name] ?? '';
            $optional = (bool)$parameter['optional'];
            $camelName = str_replace('_', '', ucwords($name, '_'));

            $parameterObject = $optional
                ? new OptionalParameter($literal, $name, $default)
                : new RequiredParameter($literal, $name, $default);

            $this->parameters[$parameterObject->getName()] = new ParameterProxy(
                $parameterObject,
                [$this, "capture$camelName"],
                [$this, "release$camelName"],
            );
        }

        foreach ($parameters as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * Retrieves the final, valid address. If the address
     * is not valid, it returns an empty string.
     *
     * @return string The final address or an empty string.
     */
    public function getAddress(): string
    {
        return $this->isValid() ? $this->getCurrentState() : '';
    }

    /**
     * Retrieves the scheme of the address
     *
     * @return string Scheme part of the address
     */
    public function getScheme(): string
    {
        return strtolower(strstr($this->getAddress(), '://', true));
    }

    /**
     * Checks if all required parameters are set.
     *
     * @return bool True if the address is valid,
     * false otherwise
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
     * Returns value of a specific parameter.
     *
     * @param string $parameter The name of the parameter.
     *
     * @return ?string The parameter value, or empty string
     * if the parameter does not exist.
     */
    public function get(string $parameter): ?string
    {
        return $this->getParameter($parameter)->getValue();
    }

    /**
     * Sets the value of a specific parameter.
     *
     * @param string $parameter The name of the parameter.
     * @param mixed $value The value to be set.
     *
     * @return Address The current instance.
     */
    public function set(string $parameter, mixed $value): Address
    {
        $this->getParameter($parameter)->setValue($value);
        return $this;
    }

    /**
     * Checks if the address contains parameters with
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
            if (!isset($this->parameters[$name])) {
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
            if (!isset($this->parameters[$name]) || !$this->parameters[$name]->isValid()) {
                return false;
            }
        }
        return true;
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
        foreach ($this->parameters as $parameter) {
            if (!$parameter->isValid()) {
                continue;
            }
            $name = $parameter->getName();
            $address = preg_replace("/{@?$name}/", $parameter->getValue(), $address);
        }
        return $address;
    }

    public function __toString(): string
    {
        return $this->getAddress();
    }

    /**
     * Get parameter by its name. Returns singleton instance
     * of null parameter if the name is not found.
     *
     * @param string $name Parameter name.
     *
     * @return ParameterContract Found parameter, or null.
     */
    private function getParameter(string $name): ParameterContract
    {
        return $this->parameters[$name] ?? NullParameter::getInstance();
    }

    /** @throws InvalidSchemeException */
    public function validate(): void
    {
        if (!preg_match('/^[a-z][a-z0-9+\-.]*$/', $this->getScheme())) {
            throw new InvalidSchemeException($this->getScheme());
        }
    }
}