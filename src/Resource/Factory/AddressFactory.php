<?php

namespace Itsmattch\Nexus\Resource\Factory;

use Itsmattch\Nexus\Resource\Component\Address;

/** Static factory class for creating Address instances. */
final class AddressFactory
{
    /**
     * Constructs an Address based on a string and optional parameters.
     *
     * @param string $address The address string to create an Address for.
     * @param array $parameters Optional parameters for the address.
     * @return Address The Address instance.
     */
    public static function from(string $address, array $parameters = []): Address
    {
        return new class($address, $parameters) extends Address {
            public function __construct(string $template, array $parameters = [])
            {
                $this->template = $template;
                parent::__construct($parameters);
            }
        };
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}