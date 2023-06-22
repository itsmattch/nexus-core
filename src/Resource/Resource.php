<?php

namespace Itsmattch\Nexus\Resource;

use Itsmattch\Nexus\Common\Traits\GetDot;
use Itsmattch\Nexus\Exceptions\Resource\Factory\EngineNotFoundException;
use Itsmattch\Nexus\Exceptions\Resource\Factory\ReaderNotFoundException;
use Itsmattch\Nexus\Resource\Component\Address;
use Itsmattch\Nexus\Resource\Component\Engine;
use Itsmattch\Nexus\Resource\Component\Reader;
use Itsmattch\Nexus\Resource\Component\Writer;
use Itsmattch\Nexus\Resource\Factory\AddressFactory;
use Itsmattch\Nexus\Resource\Factory\EngineFactory;
use Itsmattch\Nexus\Resource\Factory\ReaderFactory;

/**
 * The Resource class represents a single access point of data
 * within the Nexus system. It acts as an encapsulation of
 * all information necessary to access, read and interpret
 * a resource.
 *
 * @link https://nexus.itsmattch.com/resources/overview Resources Documentation
 */
abstract class Resource
{
    use GetDot;

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
     * Resource will use to connect to the resource. This
     * property should be set with the fully qualified class
     * name of a class that extends the Engine class.
     */
    protected string $engine = Engine::class;

    /**
     * The reader property represents the strategy that the
     * Resource will use to read and interpret the retrieved
     * data. If this property is not explicitly set, Nexus
     * will attempt to automatically select an appropriate
     * Reader based on the type of the retrieved response.
     */
    protected string $reader = Reader::class;

    /**
     * The writer property specifies the strategy that the
     * Resource will use to prepare and format the data to
     * be sent to the resource.
     *
     * This property is required for resources that aim to
     * attach requests.
     */
    protected string $writer = Writer::class;

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
     * A list of parameters passed with a Resource constructor.
     */
    private array $parameters;

    /**
     * A constructor accepting a list of address parameters.
     *
     * @param array $parameters A list of address parameters.
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /** todo */
    protected function parameter(string $parameter, mixed $default = null): mixed
    {
        return $this->parameters[$parameter] ?? $default;
    }

    /**
     * Retrieves data based on a dot notation path or
     * returns the whole data array.
     *
     * @param ?string $key The dot notation key or null to
     * retrieve the whole array.
     * @return mixed The value from the data array at the
     * specified key or the entire data array. Returns null
     * if the specified key does not exist.
     */
    public function get(?string $key = null): mixed
    {
        $array = $this->readerInstance->get();

        if ($key === null) {
            return $array;
        }
        return $this->dotKey($key, $array);
    }

    /**
     * This method creates, boots, and retrieves a Resource
     * instance and passes a set of parameters to its
     * Address component.
     *
     * @param array $parameters An array of parameters for an Address component.
     * @return Resource|null Returns Resource instance if accessed successfully, null otherwise.
     */
    public static function load(array $parameters = []): ?Resource
    {
        $instance = new static($parameters);

        if (!$instance->access()) {
            return null;
        }
        if (!$instance->read()) {
            return null;
        }

        return $instance;
    }

    /**
     * This method creates, boots, and retrieves a Resource
     * instance based on a given unique identifier.
     *
     * @param string $identifier A unique identifier value.
     * @param string $parameterName An alternative identifier parameter name.
     * @return Resource|null Returns Resource instance if accessed successfully, null otherwise.
     */
    public static function find(string $identifier, string $parameterName = 'id'): ?Resource
    {
        if (empty($identifier) || empty($parameterName)) {
            return self::load();
        }
        $parameter = [$parameterName => $identifier];

        return static::load($parameter);
    }

    /**
     * Boots the address and the engine by calling their
     * respective internal boot methods, and then attempts
     * to access the resource.
     */
    public final function access(): bool
    {
        if (!$this->internallyBootAddress()) {
            return false;
        }
        if (!$this->internallyBootEngine()) {
            return false;
        }
        if (!$this->engineInstance->access()) {
            return false;
        }
        return true;
    }

    /**
     * Boots the reader by calling its respective internal
     * boot method, and then attempts to read the accessed
     * resource.
     */
    public final function read(): bool
    {
        if (!$this->internallyBootReader()) {
            return false;
        }
        if (!$this->readerInstance->read()) {
            return false;
        }
        return true;
    }

    /**
     * Initializes the address instance and boots it up. It
     * either instantiates a subclass of Address or uses an
     * AddressFactory to do so based on the response.
     */
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

    /**
     * Initializes the engine instance and boots it up. It
     * either instantiates a subclass of Engine or uses an
     * EngineFactory to do so based on the address.
     */
    protected final function internallyBootEngine(): bool
    {
        try {
            $this->engineInstance = is_subclass_of($this->engine, Engine::class)
                ? new $this->engine($this->addressInstance)
                : EngineFactory::from($this->addressInstance);

        } catch (EngineNotFoundException) {
            return false;
        }

        $this->engineInstance->boot();

        return $this->bootEngine($this->engineInstance);
    }

    /**
     * Initializes the reader instance and boots it up. It
     * either instantiates a subclass of Reader or uses a
     * ReaderFactory to do so based on the response.
     */
    private function internallyBootReader(): bool
    {
        try {
            $this->readerInstance = is_subclass_of($this->reader, Reader::class)
                ? new $this->reader($this->engineInstance->getResponse())
                : ReaderFactory::from($this->engineInstance->getResponse());

        } catch (ReaderNotFoundException) {
            return false;
        }

        return $this->bootReader($this->readerInstance);
    }

    /**
     * This method allows you to modify created Address instance.
     *
     * @param Address $address Created Address instance.
     * @return bool The result of booting.
     */
    protected function bootAddress(Address $address): bool { return true; }

    /**
     * This method allows you to modify created Engine instance.
     *
     * @param Engine $engine Created Engine instance.
     * @return bool The result of booting.
     */
    protected function bootEngine(Engine $engine): bool { return true; }

    /**
     * This method allows you to modify created Reader instance.
     *
     * @param Reader $reader Created Reader instance.
     * @return bool The result of booting.
     */
    protected function bootReader(Reader $reader): bool { return true; }
}