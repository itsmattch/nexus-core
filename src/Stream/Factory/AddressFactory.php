<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Stream\Component\Address;

class AddressFactory
{
    public static function from(string $address): Address
    {
        // todo address registry to catch common schemes
        return new class($address) extends Address {
            public function __construct(string $template)
            {
                $this->template = $template;
                parent::__construct();
            }
        };
    }
}