<?php

namespace Itsmattch\Nexus\Stream;

use Exception;
use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Common\Bootable;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Stream as StreamContract;
use Itsmattch\Nexus\Exceptions\Common\InvalidAddressException;
use Itsmattch\Nexus\Exceptions\Common\InvalidEngineException;
use Itsmattch\Nexus\Exceptions\Common\InvalidReaderException;
use Itsmattch\Nexus\Exceptions\Common\InvalidWriterException;
use Itsmattch\Nexus\Exceptions\Stream\Factory\EngineNotFoundException;
use Itsmattch\Nexus\Exceptions\Stream\Factory\ReaderNotFoundException;
use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Component\Engine;
use Itsmattch\Nexus\Stream\Component\Reader;
use Itsmattch\Nexus\Stream\Component\Writer;
use Itsmattch\Nexus\Stream\Factory\AddressFactory;
use Itsmattch\Nexus\Stream\Factory\EngineFactory;
use Itsmattch\Nexus\Stream\Factory\ReaderFactory;

abstract class Stream implements StreamContract, Bootable, Validatable
{
    use ArrayHelpers;

    /**
     * Groups are used to cluster together different streams
     * that operate on the same data. By default, this is
     * set to the Stream's namespace, implying all Streams
     * under the same namespace are in the same group.
     */
    protected string $group;

    /**
     * Represents the location of the stream. It must be
     * either a string that points to an instance of the
     * Address class, or a URI-style string, which directly
     * represents the location of the stream. The latter
     * can include placeholders to allow for dynamic
     * parameterization of the address.
     *
     * This property is required.
     */
    protected string $address = Address::class;

    /**
     * The engine property represents the strategy that the
     * Stream will use to connect to the stream. This
     * property should be set with the fully qualified class
     * name of a class that extends the Engine class.
     */
    protected string $engine = Engine::class;

    /**
     * The reader property represents the strategy that the
     * Stream will use to read and interpret the retrieved
     * data. If this property is not explicitly set, Nexus
     * will attempt to automatically select an appropriate
     * Reader based on the type of the retrieved response.
     */
    protected string $reader = Reader::class;

    /**
     * The writer property specifies the strategy that the
     * Stream will use to prepare and format the data to
     * be sent to the stream.
     *
     * This property is required for streams that aim to
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
     * The writerInstance property is used to store the
     * instance of the Writer class that is instantiated
     * based on the value of the $writer property.
     */
    private Writer $writerInstance;

    /** A list of addressParameters passed with a Stream constructor. */
    private array $addressParameters;

    /**
     * A constructor accepting a list of address addressParameters.
     *
     * @param array $addressParameters A list of address addressParameters.
     */
    public function __construct(array $addressParameters = [])
    {
        $this->addressParameters = $addressParameters;
        $this->prepare();
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
    public final function get(?string $key = null): mixed
    {
        $array = $this->readerInstance->get();

        return empty($key) ? $array : $this->traverseDotArray($key, $array);
    }

    /**
     * This method creates, boots, and retrieves a Stream
     * instance and passes a set of addressParameters to its
     * Address component.
     *
     * @param array $addressParameters An array of addressParameters for an Address component.
     * @return Stream|null Returns Stream instance if accessed successfully, null otherwise.
     */
    public final static function load(array $addressParameters = []): ?Stream
    {
        $instance = new static($addressParameters);
        return $instance->boot() ? $instance : null;
    }

    /**
     * This method creates, boots, and retrieves a Stream
     * instance based on a given unique identifier.
     *
     * @param string $identifier A unique identifier value.
     * @param string $parameterName An alternative identifier parameter name.
     * @return Stream|null Returns Stream instance if accessed successfully, null otherwise.
     */
    public final static function find(string $identifier, string $parameterName = 'id'): ?Stream
    {
        if (empty($identifier) || empty($parameterName)) {
            return self::load();
        }
        return static::load([$parameterName => $identifier]);
    }

    /** todo */
    public final function boot(): bool
    {
        try {
            $this->validate();
            return $this->access()
                && $this->read();

        } catch (Exception) {
            return false;
        }
    }

    /** todo */
    public final function prepare(): void
    {
        if (empty($this->group)) {
            $this->group = strtolower((new \ReflectionClass($this))->getNamespaceName());
        }
    }

    /**
     * @throws InvalidReaderException
     * @throws InvalidAddressException
     * @throws InvalidWriterException
     * @throws InvalidEngineException
     */
    public final function validate(): void
    {
        if (!is_a($this->addressInstance, Address::class, true) || !str_contains($this->address, '://')) {
            throw new InvalidAddressException($this->engine);
        }

        if (!is_a($this->engine, Engine::class, true)) {
            throw new InvalidEngineException($this->engine);
        }

        if (!is_a($this->reader, Reader::class, true)) {
            throw new InvalidReaderException($this->reader);
        }

        if (!is_a($this->writer, Writer::class, true)) {
            throw new InvalidWriterException($this->writer);
        }
    }

    /**
     * Boots the address and the engine by calling their
     * respective internal boot methods, and then attempts
     * to access the stream.
     *
     * @throws EngineNotFoundException
     */
    public final function access(): bool
    {
        if (!$this->internallyBootAddress()) {
            return false;
        }
        if (!$this->internallyBootWriter()) {
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
     * stream.
     *
     * @throws ReaderNotFoundException
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
            $this->addressInstance = new $this->address($this->addressParameters);
            return $this->bootAddress($this->addressInstance);
        }
        if (str_contains($this->address, '://')) {
            $this->addressInstance = AddressFactory::from($this->address, $this->addressParameters);
            return $this->bootAddress($this->addressInstance);
        }
        return false;
    }

    /**
     * Initializes the engine instance and boots it up. It
     * either instantiates a subclass of Engine or uses an
     * EngineFactory to do so based on the address.
     *
     * @throws EngineNotFoundException
     */
    private function internallyBootEngine(): bool
    {
        $this->engineInstance = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine($this->addressInstance)
            : EngineFactory::from($this->addressInstance);

        $this->engineInstance->boot();

        return $this->bootEngine($this->engineInstance);
    }

    /**
     * Initializes the reader instance and boots it up. It
     * either instantiates a subclass of Reader or uses a
     * ReaderFactory to do so based on the response.
     *
     * @throws ReaderNotFoundException
     */
    private function internallyBootReader(): bool
    {
        $this->readerInstance = is_subclass_of($this->reader, Reader::class)
            ? new $this->reader($this->engineInstance->getResponse())
            : ReaderFactory::from($this->engineInstance->getResponse());

        return $this->bootReader($this->readerInstance);
    }

    /** todo */
    private function internallyBootWriter(): bool
    {
        $this->writerInstance = new $this->writer();
        return true;
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

    /**
     * This method allows you to modify created Writer instance.
     *
     * @param Writer $writer Created Writer instance.
     * @return bool The result of booting.
     */
    protected function bootWriter(Writer $writer): bool { return true; }

    /**
     * Returns the stream group.
     *
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->group;
    }
}