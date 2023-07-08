<?php

namespace Itsmattch\Nexus\Action;

use Itsmattch\Nexus\Address\Factory\AddressFactory;
use Itsmattch\Nexus\Contract\Action as ActionContract;
use Itsmattch\Nexus\Contract\Address;
use Itsmattch\Nexus\Contract\Common\Autonomous;
use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Reader;
use Itsmattch\Nexus\Engine\Factory\EngineFactory;
use Itsmattch\Nexus\Reader\Factory\ReaderFactory;

class Action implements ActionContract, Autonomous
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
     * The Reader that the Action will use to  interpret the
     * retrieved data.
     *
     * If this property is not explicitly set, Nexus will
     * attempt to automatically select an appropriate
     * Reader based on the type of the retrieved data.
     */
    protected string $reader = Reader::class;

    /**
     * Stores an instance of the Address.
     */
    private readonly Address $internalAddress;

    /**
     * Stores an instance of the Engine.
     */
    private readonly Engine $internalEngine;

    /**
     * Stores an instance of the Reader.
     */
    private readonly Reader $internalReader;

    /**
     * Action status.
     */
    private bool $performed;

    public function __construct()
    {
        $this->loadAddress();
        $this->loadEngine();
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

        $this->setAddress($address);
        $this->bootAddress($this->internalAddress);
    }

    /**
     * Instantiates and loads engine
     * defined in the $endine property.
     */
    private function loadEngine(): void
    {
        $engine = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine()
            : EngineFactory::from($this->internalAddress->getScheme());

        $engine->setAddress($this->internalAddress);

        $this->setEngine($engine);
        $this->bootEngine($this->internalEngine);
    }

    /**
     * @param Address $address An instance of the Address
     * class representing the resource's address.
     */
    public function setAddress(Address $address): void
    {
        $this->internalAddress = $address;
    }

    /**
     * @param Engine $engine An instance of the Engine class
     * that defines the methods for accessing the resource.
     */
    public function setEngine(Engine $engine): void
    {
        $this->internalEngine = $engine;
    }

    /**
     * @param Reader $reader An instance of the Reader class
     * that defines methods for interpreting raw resource
     * data.
     */
    public function setReader(Reader $reader): void
    {
        $this->internalReader = $reader;
    }

    public function performOnce(): void
    {
        if ($this->performed) {
            return;
        }

        $this->internalEngine->initialize();
        $this->internalEngine->execute();
        $this->internalEngine->close();
        $result = $this->internalEngine->getResponse()->body;

        $this->loadReader();
        $this->internalReader->setInput($result);
        $this->internalReader->read();

        $this->performed = true;
    }

    /**
     * Instantiates and loads the reader
     * defined in the $reader property.
     */
    private function loadReader(): void
    {
        if (!isset($this->internalReader)) {
            $reader = is_subclass_of($this->reader, Reader::class)
                ? new $this->reader()
                : ReaderFactory::from($this->internalEngine->getResponse()->type);

            $this->setReader($reader);
            $this->bootReader($this->internalReader);
        }
    }

    public function getContent(): array
    {
        return isset($this->internalReader)
            ? $this->internalReader->get()
            : [];
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
}