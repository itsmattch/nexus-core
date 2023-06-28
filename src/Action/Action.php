<?php

namespace Itsmattch\Nexus\Action;

use Itsmattch\Nexus\Address\Factory\AddressFactory;
use Itsmattch\Nexus\Contract\Action as ActionContract;
use Itsmattch\Nexus\Contract\Address;
use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Contract\Reader;
use Itsmattch\Nexus\Engine\Factory\EngineFactory;
use Itsmattch\Nexus\Reader\Factory\ReaderFactory;

class Action implements ActionContract
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

    /** Stores an instance of the Address. */
    private readonly Address $addressInstance;

    /** Stores an instance of the Engine. */
    private readonly Engine $engineInstance;

    /** Stores an instance of the Reader. */
    private readonly Reader $readerInstance;

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
        // todo
        return $this->internallyBootAddress()
            && $this->internallyBootEngine()
            && $this->internallyBootReader();
    }

    public function getContent(): array
    {
        return isset($this->readerInstance)
            ? $this->readerInstance->get()
            : [];
    }

    /** Initializes the address instance and boots it up. */
    private function internallyBootAddress(): bool
    {
        if (isset($this->address)) {
            return true;
        }

        $address = is_subclass_of($this->address, Address::class)
            ? new $this->address()
            : AddressFactory::from($this->address);

        // todo boot reader
        $this->setAddress($address);

        return $this->bootAddress($this->addressInstance);
    }

    /** Initializes the engine instance and boots it up. */
    private function internallyBootEngine(): bool
    {
        if (isset($this->engine)) {
            return true;
        }

        $engine = is_subclass_of($this->engine, Engine::class)
            ? new $this->engine()
            : EngineFactory::from($this->addressInstance->getAddress());

        // todo boot reader
        $this->setEngine($engine);

        return $this->bootEngine($this->engineInstance);
    }

    /** Initializes the reader instance and boots it up. */
    private function internallyBootReader(): bool
    {
        if (isset($this->reader)) {
            return true;
        }

        $reader = is_subclass_of($this->reader, Reader::class)
            ? new $this->reader()
            : ReaderFactory::from($this->engineInstance->getResponse()->type);

        // todo boot reader
        $this->setReader($reader);

        return $this->bootReader($this->readerInstance);
    }

    /**
     * This method allows you to modify the internally
     * instantiated Address instance.
     *
     * @param Address $address Internally created instance.
     *
     * @return bool The result of booting. False indicates
     * booting failure and will stop the booting process.
     */
    protected function bootAddress(Address $address): bool { return true; }

    /**
     * This method allows you to modify the internally
     * instantiated Engine instance.
     *
     * @param Engine $engine Created Engine instance.
     *
     *
     * @return bool The result of booting. False indicates
     * booting failure and will stop the booting process.
     */
    protected function bootEngine(Engine $engine): bool { return true; }

    /**
     * This method allows you to modify the internally
     * instantiated Reader instance.
     *
     * @param Reader $reader Internally created instance.
     *
     * @return bool The result of booting. False indicates
     * booting failure and will stop the booting process.
     */
    protected function bootReader(Reader $reader): bool { return true; }
}