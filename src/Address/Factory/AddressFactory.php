<?php

namespace Itsmattch\Nexus\Address\Factory;

use Itsmattch\Nexus\Address\Address;

/**
 * Static factory class for Address.
 */
class AddressFactory
{
    /** Disallows instantiation of the factory. */
    private function __construct() {}

    /**
     * Constructs an Address based on a passed string and
     * optional list of parameters.
     *
     * @param string $address The address string to create
     * an Address instance for.
     *
     * @return Address The Address instance.
     */
    public static function from(string $address, array $defaults = []): Address
    {
        $addressInstance = new Address();
        $addressInstance->setTemplate($address);

        foreach ($defaults as $parameter => $value) {
            $addressInstance->setDefault($parameter, $value);
        }

        return $addressInstance;
    }
}