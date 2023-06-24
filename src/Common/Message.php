<?php

namespace Itsmattch\Nexus\Common;

/**
 * A simple encapsulation of the most important
 * information received by an Engine.
 */
class Message
{
    protected readonly ?string $type;
    protected readonly string $body;

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getType(): string
    {
        return $this->type;
    }
}