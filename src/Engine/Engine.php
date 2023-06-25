<?php

namespace Itsmattch\Nexus\Engine;

use Exception;
use Itsmattch\Nexus\Address\Address;
use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Common\Bootable;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Engine as EngineContract;

abstract class Engine implements EngineContract, Bootable, Validatable
{
    /**
     * Represents the Message class that should be used
     * to encapsulate the accessed raw content.
     */
    protected string $content = Message::class;

    /**
     * Stores an instance of the Message class that is
     * created based on the value of the $content property.
     */
    private Message $contentInstance;

    /**
     * Represents the location of the resource that the
     * Engine should access.
     */
    private Address $address;

    public final function __construct(Address $address)
    {
        $this->address = $address;
    }

    /** Boots the engine in a fail-safe manner. */
    public final function boot(): bool
    {
        try {
            $this->validate();
            return $this->internallyBootContent()
                && $this->access();

        } catch (Exception) {
            return false;
        }
    }

    /**
     * A method for executing the entire process of
     * accessing a resource.
     *
     * @return bool True on successful access,
     * false otherwise.
     */
    public function access(): bool
    {
        if (!$this->init()) {
            return false;
        }
        $successful = $this->execute();
        $this->close();

        return $successful;
    }

    /**
     * A method for internally booting the Response
     * instance. It creates a new instance of the Response
     * subclass specified in the $content property.
     */
    private function internallyBootContent(): bool
    {
        $this->contentInstance = new $this->content;
        return $this->bootContent($this->contentInstance);
    }

    /**
     * This method allows you to modify created Message
     * instance for encapsulating raw content of the
     * accessed resource.
     *
     * @param Message $content Created Response instance.
     *
     * @return bool The result of booting.
     */
    protected function bootContent(Message $content): bool { return true; }

    public function getResponse(): Message
    {
        return $this->contentInstance;
    }

    protected final function address(): string
    {
        return (string)$this->address;
    }

    public function validate(): void
    {
        // todo validate $content
    }
}