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
     * The Reader that the Action will use to interpret the
     * retrieved data.
     *
     * If this property is not explicitly set, Nexus will
     * attempt to automatically select an appropriate
     * Reader based on the type of the retrieved data.
     */
    protected string $reader = Reader::class;

    /** todo */
    protected string $writer = Writer::class;

    /**
     * Stores an instance of the Address.
     */
    private readonly Address $internalAddress;

    public function __construct()
    {
        $this->loadAddress();
    }

    public function trigger(Action $action): void
    {
        $engine = $this->getEngine();
        $writer = $this->getWriter();

        // todo

        $engine->initialize();
        $engine->execute();
        $engine->close();

        $reader = $this->getReader($engine->getResponse()->type);
        $reader->setInput($engine->getResponse()->body);
        $reader->read();
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
     * Instantiates and returns engine
     * defined in the $endine property.
     */
    private function getEngine(): Engine
    {
        $engine = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine()
            : EngineFactory::from($this->internalAddress->getScheme());

        $engine->setAddress($this->internalAddress);
        $this->bootEngine($engine);
        return $engine;
    }

    /**
     * Instantiates and returns the reader
     * defined in the $reader property.
     */
    private function getReader(?string $type): Reader
    {
        $reader = is_subclass_of($this->reader, Reader::class)
            ? new $this->reader()
            : ReaderFactory::from($type);

        $this->bootReader($reader);
        return $reader;
    }

    /**
     * Instantiates and returns the writer
     * defined in the $writer property.
     */
    private function getWriter(): Writer
    {
        $writer = is_subclass_of($this->writer, Writer::class)
            ? new $this->writer()
            : null;

        $this->bootWriter($writer);
        return $writer;
    }

    /**
     * Instantiates and loads address
     * defined in the $address property.
     */
    private function loadAddress(): void
    {
        $address = is_subclass_of($this->address, Address::class)
            ? new $this->address()
            : AddressFactory::from($this->address);

        $this->internalAddress = $address;
        $this->bootAddress($this->internalAddress);
    }
}