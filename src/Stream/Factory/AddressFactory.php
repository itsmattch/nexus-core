<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Stream\Component\Address;

/** Static factory class for creating Address instances. */
final class AddressFactory
{
    /** Registry of predefined addresses mapped to schemes. */
    private static array $registry = [
        // todo
    ];

    /**
     * Constructs an Address based on a string and optional parameters.
     *
     * @param string $address The address string to create an Address for.
     * @param array $parameters Optional parameters for the address.
     * @return Address The Address instance.
     */
    public static function from(string $address, array $parameters = []): Address
    {
        // todo address registry to catch common schemes
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