<?php

namespace Itsmattch\Nexus\Address\Factory;

use Itsmattch\Nexus\Address\Address;

/** Static factory class for Address. */
class AddressFactory
{
    /**
     * Constructs an Address based on a passed string and
     * optional list of parameters.
     *
     * @param string $address The address string to create
     * an Address instance for.
     *
     * @return Address The Address instance.
     */
    public static function from(string $address): Address
    {
        return new class($address) extends Address {
            public function __construct(string $template)
            {
                $this->template = $template;
            }
        };
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}