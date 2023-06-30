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
    private readonly Address $addressInstance;

    /**
     * Stores an instance of the Engine.
     */
    private readonly Engine $engineInstance;

    /**
     * Stores an instance of the Reader.
     */
    private readonly Reader $readerInstance;

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

        $this->setEngine($engine);
        $this->bootEngine($this->engineInstance);
    }

    public function setAddress(Address $address): void
    {
        $this->addressInstance = $address;
    }

    public function setEngine(Engine $engine): void
    {
        $this->engineInstance = $engine;
    }

    public function setReader(Reader $reader): void
    {
        $this->readerInstance = $reader;
    }

    public function perform(): bool
    {
        $this->loadReader();
        return true;
    }

    /**
     * Instantiates and loads the reader
     * defined in the $reader property.
     */
    private function loadReader(): void
    {
        if (!isset($this->reader)) {
            $reader = is_subclass_of($this->reader, Reader::class)
                ? new $this->reader()
                : ReaderFactory::from($this->engineInstance->getResponse()->type);

            $this->setReader($reader);
            $this->bootReader($this->readerInstance);
        }
    }

    public function getContent(): array
    {
        return isset($this->readerInstance)
            ? $this->readerInstance->get()
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