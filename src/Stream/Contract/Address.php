<?php

namespace Itsmattch\Nexus\Stream\Contract;

use Itsmattch\Nexus\Common\Trait\CollectsErrors;
use Stringable;

/**
 * Encapsulates an address to a resource and provides a set
 * of methods to parametrize it.
 *
 * @link https://nexus.itsmattch.com/streams/addresses Addresses Documentation
 */
class Address implements Stringable
{
    use CollectsErrors;

    /** Address template. Allows mustache-styled parameters. */
    protected string $address = '';

    public function __construct() {}

    protected function collectParameters(): void {}

    /**
     * todo
     */
    public function with(string $parameterName, $value): Address
    {
        // todo
        return $this;
    }

    /**
     * todo
     */
    public function __call(string $name, array $arguments): Address
    {
        // todo
        return $this;
    }

    /**
     * todo
     */
    public function isValid(): bool
    {
        // todo
        return true;
    }

    /**
     * todo
     */
    public function getAddressCurrentState(): string
    {
        // todo
        return $this->address;
    }

    /**
     * todo
     */
    public function getAddress(): string
    {
        if (!$this->isValid()) {
            return '';
        }
        return $this->getAddressCurrentState();
    }

    /**
     * todo
     */
    public function __toString(): string
    {
        return $this->getAddress();
    }
}