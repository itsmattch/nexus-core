<?php

namespace Itsmattch\Nexus\Contract;

/**
 * Address encapsulates an address pointing to a resource.
 * The class offers methods for parametrizing the address,
 * utilizing a template-based approach for flexibility.
 *
 * @link https://nexus.itsmattch.com/the-basics/address Addresses Documentation
 */
interface Address
{
    /**
     * @param string $template The address template to be
     * parametrized.
     */
    public function setTemplate(string $template): void;

    /**
     * Sets a default value for a specific parameter in the
     * address template.
     *
     * @param string $parameter The name of the parameter.
     * @param string $value The default value to set for
     * the given parameter.
     */
    public function setDefault(string $parameter, string $value): void;

    /**
     * Retrieves the value of a specific parameter,
     * returning its explicit or default value if available.
     *
     * @param string $parameter The name of the parameter.
     * @return ?string Returns the parameter's value if set,
     * the default value if available, or null otherwise.
     */
    public function getValue(string $parameter): ?string;

    /**
     * Defines a specific value for a parameter in the
     * address template.
     *
     * @param string $parameter The name of the parameter.
     * @param string $value The value to set for the
     * specified parameter.
     */
    public function setValue(string $parameter, string $value): void;

    /**
     * @return string The complete, fully parametrized and
     * valid address.
     */
    public function getAddress(): string;

    /**
     * @return string The scheme part of the address.
     */
    public function getScheme(): string;

    /**
     * @return bool Returns true if the address is correctly
     * parametrized and valid, false otherwise.
     */
    public function isValid(): bool;
}