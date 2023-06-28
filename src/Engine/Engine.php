<?php

namespace Itsmattch\Nexus\Engine;

use Itsmattch\Nexus\Contract\Address as AddressContract;
use Itsmattch\Nexus\Contract\Engine as EngineContract;

abstract class Engine implements EngineContract
{
    protected readonly AddressContract $address;

    public function setAddress(AddressContract $address): void
    {
        $this->address = $address;
    }
}