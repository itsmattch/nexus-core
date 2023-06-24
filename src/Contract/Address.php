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
    public function getAddress(): string;

    public function getScheme(): string;

    public function isValid(): bool;
}