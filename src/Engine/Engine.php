<?php

namespace Itsmattch\Nexus\Engine;

use Exception;
use Itsmattch\Nexus\Address\Address;
use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Engine as EngineContract;

abstract class Engine implements EngineContract, Validatable
{
    /**
     * Represents the location of the resource that the
     * Engine should access.
     */
    private Address $address;

    final public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /** Boots the engine in a fail-safe manner. */
    final public function boot(): bool
    {
        try {
            $this->validate();
            if (!$this->init()) {
                return false;
            }
            $successful = $this->execute();
            $this->close();

            return $successful;

        } catch (Exception) {
            return false;
        }
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

    protected final function address(): string
    {
        return (string)$this->address;
    }

    public function validate(): void
    {
        // todo validate $content
    }
}