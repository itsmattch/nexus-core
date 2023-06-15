<?php

namespace Itsmattch\Nexus\Stream\Component;

class Response
{
    protected string $body;

    public function fill(string $body): void
    {
        $this->body = $body;
    }
}