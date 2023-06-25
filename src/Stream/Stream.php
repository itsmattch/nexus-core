<?php

namespace Itsmattch\Nexus\Stream;

use Exception;
use Itsmattch\Nexus\Address\Factory\AddressFactory;
use Itsmattch\Nexus\Common\Exception\InvalidAddressException;
use Itsmattch\Nexus\Common\Exception\InvalidEngineException;
use Itsmattch\Nexus\Common\Exception\InvalidReaderException;
use Itsmattch\Nexus\Common\Exception\InvalidWriterException;
use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Address;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Reader;
use Itsmattch\Nexus\Contract\Stream as StreamContract;
use Itsmattch\Nexus\Contract\Writer;
use Itsmattch\Nexus\Engine\Exception\EngineNotFoundException;
use Itsmattch\Nexus\Engine\Factory\EngineFactory;
use Itsmattch\Nexus\Reader\Exception\ReaderNotFoundException;
use Itsmattch\Nexus\Reader\Factory\ReaderFactory;
use ReflectionClass;

abstract class Stream implements StreamContract, Validatable
{
    use ArrayHelpers;

    /**
     * Groups are used to cluster together different streams
     * that utilize the same set of identifiers.
     *
     * By default, this is set to the Stream's namespace,
     * which implies that all Streams under the same
     * namespace are part of the same group.
     */
    protected string $group;

    /**
     * Represents the location of the stream. It must be
     * either a string that points to an instance of the
     * Address class, or a URI-style string, which directly
     * represents the location of the stream.
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
     * The reader property represents the strategy that the
     * Stream will use to read and interpret the retrieved
     * data. If this property is not explicitly set, Nexus
     * will attempt to automatically select an appropriate
     * Reader based on the type of the retrieved data.
     */
    protected string $reader = Reader::class;

    /**
     * The writer property specifies the strategy that the
     * Stream will use to prepare and format the data to
     * be sent to the stream.
     *
     * This property is required for streams that attach
     * messages, such as http request body or file input.
     */
    protected string $writer = Writer::class;

    /**
     * Stores an instance of the Address class that is
     * created based on the value of the $address property.
     */
    private Address $addressInstance;

    /**
     * Stores an instance of the Engine class that is
     * created based on the value of the $engine property.
     */
    private Engine $engineInstance;

    /**
     * Stores an instance of the Reader class that is
     * created based on the value of the $reader property.
     */
    private Reader $readerInstance;

    /**
     * Stores an instance of the Writer class that is
     * created based on the value of the $writer property.
     */
    private Writer $writerInstance;

    /**
     * A list of address parameters. These values are
     * intended to be used to fill the parameters in the
     * Address instance.
     */
    private array $addressParameters;

    /**
     * A constructor accepting a list of address parameters.
     * Automatically prepares Stream parameters.
     *
     * @param array $addressParameters A list of address
     * addressParameters.
     */
    public function __construct(array $addressParameters = [])
    {
        $this->addressParameters = $addressParameters;

        if (empty($this->group)) {
            $reflection = new ReflectionClass($this);
            $this->group = strtolower($reflection->getNamespaceName());
        }
    }

    /**
     * This method creates, boots, and retrieves a Stream
     * instance and passes a set of address parameters.
     *
     * @param array $addressParameters An array of
     * parameters for an Address component.
     *
     * @return ?Stream Returns Stream instance if booted
     * successfully, null otherwise.
     */
    final public static function load(array $addressParameters = []): ?Stream
    {
        $instance = new static($addressParameters);
        return $instance->boot() ? $instance : null;
    }

    /**
     * This shorthand method creates, boots, and retrieves a
     * Stream instance, and passes an id parameter for an
     * Address component.
     *
     * @param string $identifier A unique identifier value.
     * @param string $parameterName An alternative
     * identifier parameter name.
     *
     * @return ?Stream Returns Stream instance if booted
     * successfully, null otherwise.
     */
    final public static function find(string $identifier, string $parameterName = 'id'): ?Stream
    {
        $idParameter = empty($identifier) || empty($parameterName)
            ? [] : [$parameterName => $identifier];

        return static::load($idParameter);
    }

    /**
     * Attempts to initialize the stream in a fail-safe
     * manner. This includes validation, accessing the
     * resource, and reading the resource data. If each of
     * these steps is successful, the method returns true.
     *
     * @return bool Returns true if booted successfully,
     * false otherwise
     */
    final public function boot(): bool
    {
        try {
            $this->validate();
            return $this->access()
                && $this->read();

        } catch (Exception) {
            return false;
        }
    }

    /**
     * @throws InvalidReaderException
     * @throws InvalidAddressException
     * @throws InvalidWriterException
     * @throws InvalidEngineException
     */
    final public function validate(): void
    {
        if (!is_subclass_of($this->address, Address::class) && !str_contains($this->address, '://')) {
            throw new InvalidAddressException($this->address);
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
     * Boots the components required to access the resource,
     * and then accesses it.
     *
     * @return bool Returns true if all components were
     * successfully booted and the resource was successfully
     * accessed, false otherwise.
     *
     * @throws EngineNotFoundException
     */
    final public function access(): bool
    {
        return $this->internallyBootAddress()
            && $this->internallyBootWriter()
            && $this->internallyBootEngine()
            && $this->engineInstance->init()
            && $this->engineInstance->execute();
    }

    /**
     * Boots the reader by calling its respective internal
     * boot method, and then attempts to read the accessed
     * resource.
     *
     * @return bool Returns true if the reader was
     * successfully booted and the resource was successfully
     * read, false otherwise.
     *
     * @throws ReaderNotFoundException
     */
    final public function read(): bool
    {
        return $this->internallyBootReader()
            && $this->readerInstance->read();
    }

    final public function getResponse(): array
    {
        return $this->readerInstance->get();
    }

    /**
     * Retrieves data of the resource using a dot notation
     * path or returns the whole data array when path is
     * not specified.
     *
     * @param ?string $path The dot notation path or null to
     * retrieve the whole array.
     *
     * @return mixed The value from the data array at the
     * specified key or the entire data array. Returns null
     * if the specified key does not exist.
     */
    final public function get(?string $path = null): mixed
    {
        return empty($path) ? $this->getResponse()
            : $this->traverseDotArray($path, $this->getResponse());
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

    /** Initializes the Writer instance and boots it up. */
    private function internallyBootWriter(): bool
    {
        // $this->writerInstance = new $this->writer();
        // return $this->bootWriter($this->writerInstance);
        return true;
    }

    /**
     * This method allows you to modify created Address
     * instance.
     *
     * @param Address $address Created Address instance.
     *
     * @return bool The result of booting.
     */
    protected function bootAddress(Address $address): bool { return true; }

    /**
     * This method allows you to modify created Engine
     * instance.
     *
     * @param Engine $engine Created Engine instance.
     *
     * @return bool The result of booting.
     */
    protected function bootEngine(Engine $engine): bool { return true; }

    /**
     * This method allows you to modify created Reader
     * instance.
     *
     * @param Reader $reader Created Reader instance.
     *
     * @return bool The result of booting.
     */
    protected function bootReader(Reader $reader): bool { return true; }

    /**
     * This method allows you to modify created Writer
     * instance.
     *
     * @param Writer $writer Created Writer instance.
     *
     * @return bool The result of booting.
     */
    protected function bootWriter(Writer $writer): bool { return true; }

    public function getGroupName(): string
    {
        return $this->group;
    }
}