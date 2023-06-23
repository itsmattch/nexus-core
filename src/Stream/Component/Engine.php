<?php

namespace Itsmattch\Nexus\Stream\Component;

use Exception;
use Itsmattch\Nexus\Contract\Common\Bootable;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Stream\Engine as EngineContract;
use Itsmattch\Nexus\Stream\Component\Engine\Message;

abstract class Engine implements EngineContract, Bootable, Validatable
{
    /**
     * Represents the Response class that should be used
     * for handling the response from accessing the resource.
     */
    protected string $response = Message::class;

    /**
     * Stores the instance of the Response class that is
     * created during booting.
     */
    private Message $responseInstance;

    /**
     * Represents the location of the resource that the
     * Engine should access.
     */
    private Address $address;

    public final function __construct(Address $address)
    {
        $this->address = $address;
    }

    /** Boots the engine. */
    public final function boot(): bool
    {
        try {
            $this->validate();
            return $this->internallyBootResponse()
                && $this->init();

        } catch (Exception) {
            return false;
        }
    }

    /**
     * A method for executing the entire process of
     * accessing a resource.
     *
     * @return bool True on successful access, false otherwise.
     */
    public function access(): bool
    {
        if (!$this->execute()) {
            $this->close();
            return false;
        }
        $this->close();
        return true;
    }

    /**
     * A method for internally booting the Response
     * instance. It creates a new instance of the Response
     * subclass specified in the $response property.
     */
    private function internallyBootResponse(): bool
    {
        $this->responseInstance = new $this->response;
        return $this->bootResponse($this->responseInstance);
    }

    /**
     * This method allows you to modify created Response instance.
     *
     * @param Message $response Created Response instance.
     * @return bool The result of booting.
     */
    protected function bootResponse(Message $response): bool { return true; }

    public function getResponse(): Message
    {
        return $this->responseInstance;
    }

    protected final function address(): string
    {
        return (string)$this->address;
    }

    public function validate(): void
    {
        // TODO: Implement validate() method.
    }
}