<?php

namespace Itsmattch\Nexus\Address;

use Itsmattch\Nexus\Address\Parameter\NullParameter;
use Itsmattch\Nexus\Address\Parameter\OptionalParameter;
use Itsmattch\Nexus\Address\Parameter\ProxyParameter;
use Itsmattch\Nexus\Address\Parameter\RequiredParameter;
use Itsmattch\Nexus\Contract\Address as AddressContract;
use Itsmattch\Nexus\Contract\Address\Parameter as ParameterContract;
use Stringable;

class Address implements AddressContract, Stringable
{
    protected static string $parametersTemplate = '/(?<literal>{(?<optional>@)?(?<name>[a-z0-9_]+)})/';
    /**
     * Address template allowing parameters.
     */
    protected string $template = '';
    /**
     * Default values for parameters within the template.
     */
    protected array $defaults = [];
    /**
     * Internal template.
     */
    private readonly string $internalTemplate;
    /**
     * Internal list of default values.
     */
    private array $internalDefaults = [];
    /**
     * Collection of all parameter definitions.
     */
    private array $parameters = [];

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
        $this->loadDefaults();
        $this->loadTemplate();

        foreach ($parameters as $parameter => $value) {
            $this->setValue($parameter, $value);
        }
    }

    public function setDefault(string $parameter, string $value): void
    {
        $this->internalDefaults[$parameter] = $value;
    }

    public function getValue(string $parameter): ?string
    {
        return $this->getParameter($parameter)->getValue();
    }

    public function setValue(string $parameter, mixed $value): void
    {
        $this->getParameter($parameter)->setValue($value);
    }

    public function getAddress(): string
    {
        return $this->isValid() ? $this->getCurrentState() : '';
    }

    public function getScheme(): string
    {
        return strtolower(strstr($this->getCurrentState(), '://', true));
    }

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
     * Returns the raw address template.
     *
     * @return string The address template.
     */
    public function getTemplate(): string
    {
        return $this->internalTemplate;
    }

    public function setTemplate(string $template): void
    {
        $this->internalTemplate = $template;
        $this->loadParameters();
    }

    /**
     * Returns the address in its current state,
     * irrespective of its validity.
     *
     * @return string The address in its current state.
     */
    public function getCurrentState(): string
    {
        $address = $this->internalTemplate;
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
     * Loads the template defined in the $template property.
     */
    private function loadTemplate(): void
    {
        if (!empty($this->template)) {
            $this->setTemplate($this->template);
        }
    }

    /**
     * Iterates over the default values defined in the
     * $defaults property and sets each default value.
     */
    private function loadDefaults(): void
    {
        foreach ($this->defaults as $parameter => $value) {
            $this->setDefault($parameter, $value);
        }
    }

    /**
     * Extracts parameter definitions.
     */
    private function loadParameters(): void
    {
        preg_match_all(static::$parametersTemplate, $this->internalTemplate, $matchedParameters, PREG_SET_ORDER);

        $requiredParameters = [];
        foreach ($matchedParameters as $parameter) {
            if (in_array($parameter['name'], $requiredParameters)) {
                continue;
            }

            $name = $parameter['name'];
            $optional = (bool)$parameter['optional'];
            $literal = $parameter['literal'];
            $default = $this->internalDefaults[$name] ?? '';
            $camelName = str_replace('_', '', ucwords($name, '_'));

            if (!$optional) {
                $requiredParameters[] = $name;
            }

            $parameterObject = $optional
                ? new OptionalParameter($literal, $name, $default)
                : new RequiredParameter($literal, $name, $default);

            $this->parameters[$parameterObject->getName()] = new ProxyParameter(
                $parameterObject,
                [$this, "capture$camelName"],
                [$this, "release$camelName"],
            );
        }
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
}