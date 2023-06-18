<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Stream\Component\Address;

final class AddressFactory
{
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

    private function __construct() {}
}