<?php

namespace Itsmattch\Nexus\Resource\Component\Engine;

/** A simple encapsulation of a request. */
class Request
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