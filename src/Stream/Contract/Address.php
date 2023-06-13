<?php

namespace Itsmattch\Nexus\Stream\Contract;

use Itsmattch\Nexus\Common\Trait\CollectsErrors;
use Stringable;

/**
 *
 * @link https://nexus.itsmattch.com/streams/addresses Addresses Documentation
 */
class Address implements Stringable
{
    use CollectsErrors;

    protected string $address = '';

    public function with(string $parameterName, $value)
    {
        // todo
    }

    public function __call(string $name, array $arguments)
    {
        // todo implement callSomething handling
    }

    public function isValid(): bool
    {
        return true;
    }

    public function getAddressCurrentState(): string
    {
        // Also parse parameters
        return $this->address;
    }

    public function getAddress(): string
    {
        if (!$this->isValid()) {
            return '';
        }
        return $this->getAddressCurrentState();
    }

    public function __toString(): string
    {
        return $this->getAddress();
    }
}