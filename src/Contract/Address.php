<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Address class encapsulates an address to a resource,
 * providing a suite of methods for parametrizing it. It
 * uses a template-based approach, allowing for
 * mustache-styled parameters to define flexible addresses.
 *
 * @link https://nexus.itsmattch.com/resources/addresses Addresses Documentation
 */
interface Address
{
    /**
     * Returns the final, valid address.
     *
     * @return string The final, valid address.
     */
    public function getAddress(): string;

    /**
     * Returns the scheme of the address
     *
     * @return string Scheme part of the address
     */
    public function getScheme(): string;

    /**
     * Checks address validity.
     *
     * @return bool True if the address is valid,
     * false otherwise
     */
    public function isValid(): bool;
}