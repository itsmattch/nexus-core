<?php

namespace Itsmattch\Nexus\Resource;

use Itsmattch\Nexus\Address\Factory\AddressFactory;
use Itsmattch\Nexus\Contract\Address;
use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Reader;
use Itsmattch\Nexus\Contract\Resource as ResourceContract;
use Itsmattch\Nexus\Contract\Resource\Action;
use Itsmattch\Nexus\Contract\Writer;
use Itsmattch\Nexus\Engine\Factory\EngineFactory;
use Itsmattch\Nexus\Reader\Factory\ReaderFactory;
use Itsmattch\Nexus\Writer\Factory\WriterFactory;

class Resource implements ResourceContract
{
    /**
     * Represents the location of the resource. It must be
     * either a string that points to an Address subclass,
     * or a URI-style string, which directly represents the
     * location of the resource.
     *
     * This property is required.
     */
    protected string $address = Address::class;
    /**
     * The engine that the Action will use to connect to
     * the resource.
     *
     * If this property is not explicitly set, Nexus will
     * attempt to automatically select an appropriate
     * Engine based on the address scheme.
     */
    protected string $engine = Engine::class;
    /**
     * Specifies the data format that the Reader and Writer
     * will use to read and write the resource data.
     */
    protected string $format = '';
    /**
     * Stores an instance of the Address.
     */
    private readonly Address $addressInstance;
    /**
     * Stores an instance of the Engine.
     */
    private readonly Engine $engineInstance;
    /**
     * Stores an instance of the Reader.
     */
    private readonly Reader $readerInstance;
    /**
     * Stores an instance of the Writer.
     */
    private readonly Writer $writerInstance;

    public function trigger(?Action $action = null): array
    {
        // Ensure the internal engine is in a clean state
        // before starting a new action.
        $this->engineInstance->close();

        // Act
        $action?->act($this);

        // Init, exec & close
        $this->engineInstance->initialize();
        $response = $this->engineInstance->execute();
        $this->engineInstance->close();

        // Return the content read from the response body.
        return $this->readerInstance->read($response);
    }

    public function getAddress(): Address
    {
        if (!isset($this->addressInstance)) {
            $this->loadAddress();
        }

        return $this->addressInstance;
    }

    public function setAddress(Address $address): void
    {
        if (!isset($this->addressInstance)) {
            $this->addressInstance = $address;
        }
    }

    public function getEngine(): Engine
    {
        if (!isset($this->engineInstance)) {
            $this->loadEngine();
        }

        return $this->engineInstance;
    }

    public function setEngine(Engine $engine): void
    {
        if (!isset($this->engineInstance)) {
            $this->engineInstance = $engine;
        }
    }

    public function getReader(): Reader
    {
        if (!isset($this->readerInstance)) {
            $this->loadReader();
        }

        return $this->readerInstance;
    }

    public function setReader(Reader $reader): void
    {
        if (!isset($this->readerInstance)) {
            $this->readerInstance = $reader;
        }
    }

    public function getWriter(): Writer
    {
        if (!isset($this->writerInstance)) {
            $this->loadWriter();
        }

        return $this->writerInstance;
    }

    public function setWriter(Writer $writer): void
    {
        if (!isset($this->writerInstance)) {
            $this->writerInstance = $writer;
        }
    }

    /**
     * This method allows you to modify the internally
     * instantiated Address instance.
     *
     * @param Address $address Internally created instance.
     */
    protected function bootAddress(Address $address): void {}

    /**
     * This method allows you to modify the internally
     * instantiated Engine instance.
     *
     * @param Engine $engine Created Engine instance.
     */
    protected function bootEngine(Engine $engine): void {}

    /**
     * This method allows you to modify the internally
     * instantiated Reader instance.
     *
     * @param Reader $reader Internally created instance.
     */
    protected function bootReader(Reader $reader): void {}

    /**
     * This method allows you to modify the internally
     * instantiated Writer instance.
     *
     * @param Writer $writer Internally created instance.
     */
    protected function bootWriter(Writer $writer): void {}

    /**
     * Instantiates and loads address
     * defined in the $address property.
     */
    private function loadAddress(): void
    {
        $address = is_subclass_of($this->address, Address::class)
            ? new $this->address()
            : AddressFactory::from($this->address);

        $this->addressInstance = $address;
        $this->bootAddress($this->addressInstance);
    }

    /**
     * Instantiates and loads engine
     * defined in the $endine property.
     */
    private function loadEngine(): void
    {
        $engine = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine()
            : EngineFactory::from($this->addressInstance->getScheme());

        $engine->setAddress($this->addressInstance);

        $this->engineInstance = $engine;
        $this->bootEngine($this->engineInstance);
    }

    /**
     * Instantiates and loads the reader
     * based on the $format.
     */
    private function loadReader(): void
    {
        $this->readerInstance = ReaderFactory::from($this->format);
        $this->bootReader($this->readerInstance);
    }

    /**
     * Instantiates and loads the writer
     * based on the $format.
     */
    private function loadWriter(): void
    {
        $this->writerInstance = WriterFactory::from($this->format);
        $this->bootWriter($this->writerInstance);
    }
}