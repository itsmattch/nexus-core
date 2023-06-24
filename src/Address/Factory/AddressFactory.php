<?php

namespace Itsmattch\Nexus\Address\Factory;

use Itsmattch\Nexus\Address\Address;

/** Static factory class for Address. */
final class AddressFactory
{
    /**
     * Constructs an Address based on a passed string and
     * optional list of parameters.
     *
     * @param string $address The address string to create
     * an Address instance for.
     * @param array $parameters Optional parameters passed
     * with the constructor.
     *
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