<?php

namespace Itsmattch\Nexus\Stream;

use Itsmattch\Nexus\Base\Resource;
use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Component\Engine;
use Itsmattch\Nexus\Stream\Component\Reader;
use Itsmattch\Nexus\Stream\Component\Response;
use Itsmattch\Nexus\Stream\Factory\AddressFactory;

/**
 * The Stream class represents a single access point of data
 * within the Nexus system. It acts as an encapsulation of
 * all information necessary to access, read and interpret
 * a resource.
 */
class Stream
{
    /**
     * Represents the location of the resource. It must be
     * either a string that points to an instance of the
     * Address class, or a URI-style string, which directly
     * represents the location of the resource. The latter
     * can include placeholders to allow for dynamic
     * parameterization of the address.
     *
     * This property is required.
     */
    protected string $address = Address::class;

    /**
     * The engine property represents the strategy that the
     * Stream will use to connect to the resource. This
     * property should be set with the fully qualified class
     * name of a class that extends the Engine class.
     *
     * This property is required.
     */
    protected string $engine = Engine::class;

    /**
     * The reader property represents the strategy that the
     * Stream will use to read and interpret the retrieved
     * data. If this property is not explicitly set, Nexus
     * will attempt to automatically select an appropriate
     * Reader based on the type of the retrieved resource.
     */
    protected string $reader = Reader::class;

    /**
     * Nexus provides a default Resource class that is often
     * sufficient for general use, but it can be replaced
     * with a custom Resource class if necessary for more
     * specific needs.
     */
    protected string $resource = Resource::class;

    /**
     * Stores instance of the Address class that is created
     * based on the value of the $address property.
     */
    private Address $addressInstance;

    /**
     * The engineInstance property is used to store the
     * instance of the Engine class that is instantiated
     * based on the value of the $engine property.
     */
    private Engine $engineInstance;

    /**
     * The readerInstance property is used to store the
     * instance of the Reader class that is instantiated
     * based on the value of the $reader property.
     */
    private Reader $readerInstance;

    /**
     * The resourceInstance property is used to store the
     * instance of the Resource class that is instantiated
     * based on the value of the $resource property.
     */
    private Resource $resourceInstance;

    /**
     * Boots all components by calling their respective
     * internal boot methods. Each method is then calling
     * standard boot method, which can be extended to
     * modify created components instances.
     */
    public final function boot(): bool
    {
        if (!$this->internallyBootAddress()) {
            return false;
        }
        if (!$this->internallyBootEngine()) {
            return false;
        }
        if (!$this->internallyBootReader()) {
            return false;
        }
        if (!$this->internallyBootResource()) {
            return false;
        }
        return true;
    }

    protected final function internallyBootAddress(): bool
    {
        if (is_a($this->address, Address::class)) {
            $this->addressInstance = new $this->address;
            return $this->bootAddress($this->addressInstance);
        } else if (str_contains($this->address, '://')) {
            $this->address = AddressFactory::from($this->address);
            return $this->bootAddress($this->addressInstance);
        }
        return false;
    }

    protected final function internallyBootEngine(): bool
    {
        $this->engineInstance = new $this->engine;
        return $this->bootEngine($this->engineInstance);
    }

    protected final function internallyBootReader(): bool
    {
        $this->readerInstance = new $this->reader;
        return $this->bootReader($this->readerInstance);
    }

    protected final function internallyBootResource(): bool
    {
        $this->resourceInstance = new $this->resource;
        return $this->bootResource($this->resourceInstance);
    }

    protected function bootAddress(Address $address): bool { return true; }

    protected function bootEngine(Engine $engine): bool { return true; }

    protected function bootReader(Reader $reader): bool { return true; }

    protected function bootResource(Resource $resource): bool { return true; }

    public function access(): bool
    {
        return $this->engineInstance->access($this->addressInstance);
    }

    public function getResponse(): Response
    {
        return $this->engineInstance->getResponse();
    }

    public function getResource(): Resource
    {
        return $this->resourceInstance;
    }
}