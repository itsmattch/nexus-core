<?php

namespace Itsmattch\NexusCore\Engine;

use Itsmattch\NexusCore\Contract\Address as AddressContract;
use Itsmattch\NexusCore\Contract\Engine as EngineContract;

abstract class Engine implements EngineContract
{
    protected readonly AddressContract $address;

    public function setAddress(AddressContract $address): void
    {
        $this->address = $address;
    }
}