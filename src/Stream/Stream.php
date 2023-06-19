<?php

namespace Itsmattch\Nexus\Stream;

use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Component\Engine;
use Itsmattch\Nexus\Stream\Component\Engine\Response;
use Itsmattch\Nexus\Stream\Component\Reader;
use Itsmattch\Nexus\Stream\Component\Resource;
use Itsmattch\Nexus\Stream\Factory\AddressFactory;
use Itsmattch\Nexus\Stream\Factory\EngineFactory;
use Itsmattch\Nexus\Stream\Factory\ReaderFactory;

/**
 * The Stream class represents a single access point of data
 * within the Nexus system. It acts as an encapsulation of
 * all information necessary to access, read and interpret
 * a resource.
 */
abstract class Stream
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
     */
    protected string $engine = Engine::class;

    /**
     * Nexus provides a default Resource class that is often
     * sufficient for general use, but it can be replaced
     * with a custom Resource class if necessary for more
     * specific needs.
     */
    protected string $resource = Resource::class;

    /**
     * The reader property represents the strategy that the
     * Stream will use to read and interpret the retrieved
     * data. If this property is not explicitly set, Nexus
     * will attempt to automatically select an appropriate
     * Reader based on the type of the retrieved resource.
     */
    protected string $reader = Reader::class;

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

    protected array $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * This method creates, boots, and retrieves a Stream
     * instance and passes a set of parameters to its
     * Address component.
     *
     * @param array $parameters An array of parameters for an Address component.
     * @return Stream|null Returns Stream instance if accessed successfully, null otherwise.
     */
    public static function get(array $parameters = []): ?Stream
    {
        $instance = new static($parameters);

        if (!$instance->load()) {
            return null;
        }
        if (!$instance->read()) {
            return null;
        }

        return $instance;
    }

    /**
     * This method creates, boots, and retrieves a Stream
     * instance based on a given unique identifier.
     *
     * @param string $identifier A unique identifier value.
     * @param string $parameterName An alternative identifier parameter name.
     * @return Stream|null Returns Stream instance if accessed successfully, null otherwise.
     */
    public static function find(string $identifier = '', string $parameterName = 'id'): ?Stream
    {
        if (empty($identifier) || empty($parameterName)) {
            return self::get();
        }
        $parameter = [$parameterName => $identifier];

        return static::get($parameter);
    }

    /**
     * Boots all components by calling their respective
     * internal boot methods. Each method is then calling
     * standard boot method, which can be extended to
     * modify created components instances.
     */
    public final function load(): bool
    {
        if (!$this->internallyBootAddress()) {
            return false;
        }
        if (!$this->internallyBootEngine()) {
            return false;
        }
        return $this->engineInstance->access();
    }

    public final function read(): bool
    {
        if (!$this->internallyBootResource()) {
            return false;
        }
        if (!$this->internallyBootReader()) {
            return false;
        }
        return $this->readerInstance->read();
    }

    /** todo */
    private function internallyBootAddress(): bool
    {
        if (is_subclass_of($this->address, Address::class)) {
            $this->addressInstance = new $this->address($this->parameters);
            return $this->bootAddress($this->addressInstance);
        }
        if (str_contains($this->address, '://')) {
            $this->addressInstance = AddressFactory::from($this->address, $this->parameters);
            return $this->bootAddress($this->addressInstance);
        }
        return false;
    }

    /** todo */
    protected final function internallyBootEngine(): bool
    {
        $this->engineInstance = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine($this->addressInstance)
            : EngineFactory::from($this->addressInstance);

        $this->engineInstance->boot();

        return $this->bootEngine($this->engineInstance);
    }

    /** todo */
    private function internallyBootResource(): bool
    {
        $this->resourceInstance = new $this->resource;
        return $this->bootResource($this->resourceInstance);
    }

    /** todo */
    private function internallyBootReader(): bool
    {
        $this->readerInstance = is_subclass_of($this->reader, Reader::class)
            ? new $this->reader($this->engineInstance->getResponse(), $this->resourceInstance)
            : ReaderFactory::from($this->engineInstance->getResponse(), $this->resourceInstance);

        return $this->bootReader($this->readerInstance);
    }

    /** todo */
    protected function bootAddress(Address $address): bool { return true; }

    /** todo */
    protected function bootEngine(Engine $engine): bool { return true; }

    /** todo */
    protected function bootResource(Resource $resource): bool { return true; }

    /** todo */
    protected function bootReader(Reader $reader): bool { return true; }

    /** todo */
    public function getResponse(): Response
    {
        return $this->engineInstance->getResponse();
    }

    /** todo */
    public function getResource(): Resource
    {
        return $this->resourceInstance;
    }
}